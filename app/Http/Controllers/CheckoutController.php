<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Keranjang;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Pembayaran;
use App\Models\Pengiriman;
use App\Models\UkuranProduk;
use App\Models\JenisWarnaProduk;
use App\Models\RequestWarna;
use App\Models\KodeWarnaRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    /**
     * Process checkout request (can handle single or multiple products)
     */
    public function checkout(Request $request)
    {
        // Validation rules that work for both single and multiple products
        $rules = [
            'produk_id' => 'required',
            'ukuran_id' => 'nullable',
            'warna_id' => 'nullable',
            'kode_warna' => 'nullable|array',
            'kode_warna.*' => 'nullable|string|max:7',
            'pre_order' => 'nullable|boolean',
            'jumlah' => 'required'
        ];

        // If arrays, validate each item
        if (is_array($request->produk_id)) {
            $rules = [
                'produk_id.*' => 'required|exists:produk,id',
                'ukuran_id.*' => 'nullable|exists:ukuran_produk,id',
                'warna_id.*' => 'nullable|exists:jenis_warna_produk,id',
                'jumlah.*' => 'required|integer|min:1',
            ];
        } else {
            $rules = [
                'produk_id' => 'required|exists:produk,id',
                'ukuran_id' => 'nullable|exists:ukuran_produk,id',
                'warna_id' => 'nullable|exists:jenis_warna_produk,id',
                'jumlah' => 'required|integer|min:1',
            ];
        }

        $request->validate($rules, [
            'produk_id.*.required' => 'Produk harus dipilih.',
            'produk_id.required' => 'Produk harus dipilih.',
            'jumlah.*.required' => 'Jumlah harus diisi.',
            'jumlah.required' => 'Jumlah harus diisi.',
            'jumlah.*.integer' => 'Jumlah harus berupa angka.',
            'jumlah.integer' => 'Jumlah harus berupa angka.',
            'jumlah.*.min' => 'Jumlah minimal adalah 1.',
            'jumlah.min' => 'Jumlah minimal adalah 1.',
        ]);

        // Normalize data to array format
        $produkIds = is_array($request->produk_id) ? $request->produk_id : [$request->produk_id];
        $ukuranIds = is_array($request->ukuran_id) ? $request->ukuran_id : [$request->ukuran_id];
        $warnaIds = is_array($request->warna_id) ? $request->warna_id : [$request->warna_id];
        $jumlahs = is_array($request->jumlah) ? $request->jumlah : [$request->jumlah];

        $checkoutData = [];
        $totalHarga = 0;

        foreach ($produkIds as $index => $produkId) {
            $produk = Produk::with(['katalog'])->findOrFail($produkId);

            // Handle optional ukuran and warna
            $ukuran = null;
            $warna = null;

            if (!empty($ukuranIds[$index])) {
                $ukuran = UkuranProduk::findOrFail($ukuranIds[$index]);
            }

            if (!empty($warnaIds[$index])) {
                $warna = JenisWarnaProduk::findOrFail($warnaIds[$index]);
            }

            $jumlah = $jumlahs[$index];

            // Check stock availability
            if ($produk->stok < $jumlah) {
                return response()->json([
                    'success' => false,
                    'message' => "Stok produk {$produk->nama} tidak mencukupi. Stok tersedia: {$produk->stok}"
                ], 400);
            }

            $subtotal = $produk->harga * $jumlah;
            $totalHarga += $subtotal;

            $checkoutData[] = [
                'produk' => $produk,
                'ukuran' => $ukuran,
                'warna' => $warna,
                'jumlah' => $jumlah,
                'harga_satuan' => $produk->harga,
                'subtotal' => $subtotal,
                'produk_id' => $produkId,
                'ukuran_id' => $ukuranIds[$index] ?? null,
                'warna_id' => $warnaIds[$index] ?? null,
                'kode_warna' => $request->kode_warna ?? null,
                'pre_order' => $request->pre_order ?? false,
            ];
        }

        $grandTotal = $totalHarga;

        // If AJAX request, return checkout page URL
        if ($request->ajax()) {
            // Store checkout data in session temporarily
            session([
                'checkout_data' => $checkoutData,
                'checkout_totals' => [
                    'subtotal' => $totalHarga,
                    'total' => $grandTotal
                ]
            ]);

            return response()->json([
                'success' => true,
                'redirect_url' => route('pelanggan.checkout.form')
            ]);
        }

        return view('pelanggan.checkout', compact('checkoutData', 'totalHarga', 'ongkir', 'grandTotal'));
    }

    /**
     * Show checkout form
     */
    public function showCheckoutForm()
    {
        $checkoutData = session('checkout_data');
        $totals = session('checkout_totals');

        if (!$checkoutData) {
            return redirect()->route('pelanggan.katalog')
                ->with('error', 'Data checkout tidak ditemukan. Silakan pilih produk terlebih dahulu.');
        }

        return view('pelanggan.checkout', [
            'checkoutData' => $checkoutData,
            'totalHarga' => $totals['subtotal'],
            'grandTotal' => $totals['total']
        ]);
    }

    /**
     * Process the checkout and create transaction
     */
    public function processCheckout(Request $request)
    {
        $request->validate([
            'alamat' => 'required|string|max:500',
            'provinsi' => 'required|string|max:500',
            'kota' => 'required|string|max:500',
            'kode_pos' => 'required|string|max:500',
            'telepon' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'catatan' => 'nullable|string|max:1000',
            'ongkir_cost' => 'required|string|max:1000',
        ], [
            'alamat.required' => 'Alamat pengiriman harus diisi.',
            'provinsi.required' => 'Provinsi harus diisi.',
            'kota.required' => 'Kota harus diisi.',
            'kode_pos.required' => 'Kode pos harus diisi.',
            'telepon.required' => 'Nomor telepon harus diisi.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'catatan.max' => 'Catatan tidak boleh lebih dari 1000 karakter.',
            'ongkir_cost.required' => 'Biaya ongkir harus diisi.',
        ]);

        $checkoutData = session('checkout_data');
        $totals = session('checkout_totals');
        $checkoutSource = session('checkout_source'); // 'cart' or null

        if (!$checkoutData || !$totals) {
            return redirect()->route('pelanggan.katalog')
                ->with('error', 'Data checkout tidak ditemukan. Silakan pilih produk terlebih dahulu.');
        }

        try {
            DB::beginTransaction();

            // Create transaction
            $alamatLengkap = $request->alamat . ', ' . $request->kota . ', ' . $request->provinsi .' ' . $request->kode_pos;
            $namaPembeli = Auth::user()->name;
            $transaksi = Transaksi::create([
                'user_id' => Auth::check() ? Auth::id() : null,
                'kode_transaksi' => 'TRX' . strtoupper(Str::random(8)),
                'status' => 'pending',
                'subtotal' => $totals['subtotal'],
                'ongkir' => $request->ongkir_cost,
                'total' => $totals['subtotal'] + $request->ongkir_cost,
                'catatan' => $request->catatan,
                'alamat_pengiriman' => $alamatLengkap,
            ]);

            // Create transaction details
            $hasRequestWarna = false;
            $requestWarnaData = [];
            $isPreOrder = false;

            foreach ($checkoutData as $item) {
                DetailTransaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'produk_id' => $item['produk_id'],
                    'jumlah' => $item['jumlah'],
                    'harga_satuan' => $item['harga_satuan'],
                    'total_harga' => $item['subtotal'],
                    'ukuran_produk_id' => $item['ukuran_id'],
                    'jenis_warna_produk_id' => $item['warna_id'],
                ]);

                // Check if this item has custom color request
                if (!empty($item['kode_warna']) && is_array($item['kode_warna'])) {
                    $hasRequestWarna = true;
                    $requestWarnaData = $item['kode_warna'];
                }

                // Check if this is pre-order
                if ($item['pre_order']) {
                    $isPreOrder = true;
                }

                // Update product stock
                $produk = Produk::findOrFail($item['produk_id']);
                $produk->decrement('stok', $item['jumlah']);
            }

            // Update transaction status if it's pre-order
            if ($isPreOrder || $hasRequestWarna) {
                $transaksi->update(['preorder' => true]);
            }

            // Create request warna if there are custom colors
            if ($hasRequestWarna && !empty($requestWarnaData)) {
                $requestWarna = RequestWarna::create([
                    'transaksi_id' => $transaksi->id,
                ]);

                // Create kode warna request for each color
                foreach ($requestWarnaData as $kodeWarna) {
                    if (!empty($kodeWarna)) {
                        KodeWarnaRequest::create([
                            'request_warna_id' => $requestWarna->id,
                            'kode_warna' => $kodeWarna,
                        ]);
                    }
                }
            }            // Create payment record
            // Pembayaran::create([
            //     'transaksi_id' => $transaksi->id,
            //     'metode_pembayaran' => $request->metode_pembayaran,
            //     'jumlah' => $totals['total'],
            //     'total_pembayaran' => $totals['total'],
            //     'status' => 'pending',
            //     'tanggal_pembayaran' => null,
            // ]);

            // // Create shipping record
            // Pengiriman::create([
            //     'transaksi_id' => $transaksi->id,
            //     'nama_penerima' => $namaPembeli,
            //     'no_resi' => 'RESI' . strtoupper(Str::random(8)),
            //     'ongkir' => $totals['ongkir'],
            //     'berat' => count($checkoutData), // 1 kg per item
            //     'alamat_pengiriman' => $alamatLengkap,
            //     'alamat_penerima' => $alamatLengkap,
            //     'catatan' => $request->catatan ?? '',
            // ]);

            DB::commit();

            // If checkout came from cart, clear cart items
            if ($checkoutSource === 'cart') {
                $keranjangIds = collect($checkoutData)->pluck('keranjang_id')->filter();
                if ($keranjangIds->isNotEmpty()) {
                    Keranjang::whereIn('id', $keranjangIds)->delete();
                }
            }

            // Clear checkout session data
            session()->forget(['checkout_data', 'checkout_totals', 'checkout_source']);

            if($isPreOrder) {
                if (request()->ajax()) {
                    return response()->json([
                        'success' => true,
                        'redirect' => route('pelanggan.transaksi'),
                        'message' => 'Pesanan berhasil dibuat!'
                    ]);
                }
                return redirect()->route('pelanggan.transaksi')
                    ->with('success', 'Pesanan pre-order berhasil dibuat! Silakan tunggu konfirmasi dari admin.');
            }

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'redirect' => route('pelanggan.checkout.success', $transaksi->kode_transaksi),
                    'message' => 'Pesanan berhasil dibuat!'
                ]);
            }
            return redirect()->route('pelanggan.checkout.success', $transaksi->kode_transaksi)
                ->with('success', 'Pesanan berhasil dibuat!');

        } catch (\Exception $e) {
            DB::rollBack();

            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat memproses pesanan: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memproses pesanan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Show success page
     */
    public function success($kode_transaksi)
    {
        $transaksi = Transaksi::with([
            'detailTransaksi.produk',
            'detailTransaksi.ukuranProduk',
            'detailTransaksi.jenisWarnaProduk',
            'requestWarna.kodeWarnaRequests'
        ])->where('kode_transaksi', $kode_transaksi)->firstOrFail();

        $pembayaran = Pembayaran::where('transaksi_id', $transaksi->id)->first();
        $pengiriman = Pengiriman::where('transaksi_id', $transaksi->id)->first();

        return view('pelanggan.checkout-success', compact('transaksi', 'pembayaran', 'pengiriman'));
    }

    /**
     * Checkout from cart - prepare cart items for checkout
     */
    public function checkoutFromCart()
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Anda harus login untuk melanjutkan checkout.');
        }

        // Get all cart items for current user
        $keranjangItems = Keranjang::where('user_id', Auth::id())
            ->with(['produk.katalog', 'ukuranProduk', 'jenisWarnaProduk'])
            ->get();

        if ($keranjangItems->isEmpty()) {
            return redirect()->route('pelanggan.keranjang.index')
                ->with('error', 'Keranjang Anda kosong. Silakan tambahkan produk terlebih dahulu.');
        }

        $checkoutData = [];
        $totalHarga = 0;

        foreach ($keranjangItems as $item) {
            // Check stock availability
            if ($item->produk->stok < $item->jumlah) {
                return redirect()->route('pelanggan.keranjang.index')
                    ->with('error', "Stok produk {$item->produk->nama} tidak mencukupi. Stok tersedia: {$item->produk->stok}");
            }

            $subtotal = $item->produk->harga * $item->jumlah;
            $totalHarga += $subtotal;

            $checkoutData[] = [
                'produk' => $item->produk,
                'ukuran' => $item->ukuranProduk,
                'warna' => $item->jenisWarnaProduk,
                'jumlah' => $item->jumlah,
                'harga_satuan' => $item->produk->harga,
                'subtotal' => $subtotal,
                'produk_id' => $item->produk_id,
                'ukuran_id' => $item->ukuran_produk_id,
                'warna_id' => $item->jenis_warna_produk_id,
                'keranjang_id' => $item->id, // Store cart item ID for later cleanup
                'pre_order' => false, // Default false untuk checkout dari keranjang
                'kode_warna' => null, // Default null untuk checkout dari keranjang
            ];
        }

        // Calculate shipping cost
        $ongkir = 15000 + (count($checkoutData) - 1) * 5000;
        $grandTotal = $totalHarga + $ongkir;

        // Store checkout data in session
        session([
            'checkout_data' => $checkoutData,
            'checkout_totals' => [
                'subtotal' => $totalHarga,
                'ongkir' => $ongkir,
                'total' => $grandTotal
            ],
            'checkout_source' => 'cart' // Mark that this checkout came from cart
        ]);

        return redirect()->route('pelanggan.checkout.form');
    }
}
