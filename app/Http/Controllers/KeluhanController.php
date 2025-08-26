<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Keluhan;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Models\KeluhanBalasan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class KeluhanController extends Controller
{
    /**
     * Display a listing of keluhan for customer
     */
    public function index()
    {
        $keluhans = Keluhan::where('user_id', Auth::id())
            ->with(['transaksi'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('pelanggan.keluhan.index', compact('keluhans'));
    }

    /**
     * Show the form for creating a new keluhan
     */
    public function create(Request $request)
    {
        $transaksi_id = $request->get('transaksi_id');
        $transaksi = null;

        if ($transaksi_id) {
            $transaksi = Transaksi::where('id', $transaksi_id)
                ->where('user_id', Auth::id())
                ->first();
        }

        return view('pelanggan.keluhan.create', compact('transaksi'));
    }

    /**
     * Store a newly created keluhan
     */
    public function store(Request $request)
    {
        $request->validate([
            'subjek' => 'required|string|max:255',
            'pesan' => 'required|string',
            'kategori' => 'required|in:produk,pengiriman,pembayaran,layanan,lainnya',
            'transaksi_id' => 'nullable|exists:transaksi,id',
            'lampiran' => 'nullable|array|max:3',
            'lampiran.*' => 'file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048'
        ]);

        try {
            DB::beginTransaction();

            // Handle file uploads
            $lampiranFiles = [];
            if ($request->hasFile('lampiran')) {
                foreach ($request->file('lampiran') as $file) {
                    $path = $file->store('keluhan/lampiran', 'public');
                    $lampiranFiles[] = [
                        'path' => $path,
                        'original_name' => $file->getClientOriginalName(),
                        'mime_type' => $file->getMimeType(),
                        'size' => $file->getSize()
                    ];
                }
            }

            // Validate transaksi ownership
            $transaksi_id = $request->transaksi_id;
            if ($transaksi_id) {
                $transaksi = Transaksi::where('id', $transaksi_id)
                    ->where('user_id', Auth::id())
                    ->first();

                if (!$transaksi) {
                    $transaksi_id = null;
                }
            }

            $keluhan = Keluhan::create([
                'user_id' => Auth::id(),
                'transaksi_id' => $transaksi_id,
                'subjek' => $request->subjek,
                'pesan' => $request->pesan,
                'kategori' => $request->kategori,
                'prioritas' => 'normal',
                'lampiran' => $lampiranFiles
            ]);

            DB::commit();

            return redirect()->route('pelanggan.keluhan.show', $keluhan)
                ->with('success', 'Keluhan berhasil dikirim. Kode tiket: ' . $keluhan->kode_tiket);

        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan keluhan.'])
                ->withInput();
        }
    }

    /**
     * Display the specified keluhan for customer
     */
    public function show(Keluhan $keluhan)
    {
        // Pastikan user hanya bisa melihat keluhan miliknya
        if ($keluhan->user_id !== Auth::id()) {
            abort(403);
        }

        $keluhan->load(['transaksi', 'balasans.user']);

        return view('pelanggan.keluhan.show', compact('keluhan'));
    }

    /**
     * Reply to keluhan (customer)
     */
    public function reply(Request $request, Keluhan $keluhan)
    {
        // Pastikan user hanya bisa reply keluhan miliknya
        if ($keluhan->user_id !== Auth::id()) {
            abort(403);
        }

        if (!$keluhan->canBeReplied()) {
            return back()->withErrors(['error' => 'Keluhan ini sudah ditutup dan tidak dapat dibalas.']);
        }

        $request->validate([
            'pesan' => 'required|string',
            'lampiran' => 'nullable|array|max:3',
            'lampiran.*' => 'file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048'
        ]);

        try {
            DB::beginTransaction();

            // Handle file uploads
            $lampiranFiles = [];
            if ($request->hasFile('lampiran')) {
                foreach ($request->file('lampiran') as $file) {
                    $path = $file->store('keluhan/lampiran', 'public');
                    $lampiranFiles[] = [
                        'path' => $path,
                        'original_name' => $file->getClientOriginalName(),
                        'mime_type' => $file->getMimeType(),
                        'size' => $file->getSize()
                    ];
                }
            }

            // Create reply
            KeluhanBalasan::create([
                'keluhan_id' => $keluhan->id,
                'user_id' => Auth::id(),
                'pesan' => $request->pesan,
                'dari' => 'pelanggan',
                'lampiran' => $lampiranFiles
            ]);

            // Update keluhan
            $keluhan->update([
                'last_response_at' => now(),
                'last_response_by' => 'user',
                'status' => $keluhan->status === Keluhan::STATUS_MENUNGGU_PELANGGAN
                    ? Keluhan::STATUS_DALAM_PROSES
                    : $keluhan->status
            ]);

            DB::commit();

            return back()->with('success', 'Balasan berhasil dikirim.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Terjadi kesalahan saat mengirim balasan.']);
        }
    }

    // ============ ADMIN METHODS ============

    /**
     * Display a listing of keluhan for admin
     */
    public function adminIndex(Request $request)
    {
        $query = Keluhan::with(['user', 'transaksi']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by category
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        // Filter by priority
        if ($request->filled('prioritas')) {
            $query->where('prioritas', $request->prioritas);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('kode_tiket', 'like', "%{$search}%")
                  ->orWhere('subjek', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $keluhans = $query->orderBy('created_at', 'desc')->paginate(15);

        // Statistics
        $stats = [
            'total' => Keluhan::count(),
            'buka' => Keluhan::where('status', Keluhan::STATUS_BUKA)->count(),
            'dalam_proses' => Keluhan::where('status', Keluhan::STATUS_DALAM_PROSES)->count(),
            'menunggu_pelanggan' => Keluhan::where('status', Keluhan::STATUS_MENUNGGU_PELANGGAN)->count(),
            'selesai' => Keluhan::where('status', Keluhan::STATUS_SELESAI)->count(),
            'urgent' => Keluhan::where('prioritas', Keluhan::PRIORITY_URGENT)->count(),
        ];

        return view('admin.keluhan.index', compact('keluhans', 'stats'));
    }

    /**
     * Display the specified keluhan for admin
     */
    public function adminShow(Keluhan $keluhan)
    {
        $keluhan->load(['user', 'transaksi', 'balasans.user']);

        return view('admin.keluhan.show', compact('keluhan'));
    }

    /**
     * Reply to keluhan (admin)
     */
    public function adminReply(Request $request, Keluhan $keluhan)
    {
        $request->validate([
            'pesan' => 'required|string',
            'is_internal' => 'boolean',
            'auto_status_update' => 'boolean',
            'lampiran' => 'nullable|array|max:3',
            'lampiran.*' => 'file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048'
        ]);

        try {
            DB::beginTransaction();

            $isInternal = $request->boolean('is_internal', false);

            // Handle file uploads
            $lampiranFiles = [];
            if ($request->hasFile('lampiran')) {
                foreach ($request->file('lampiran') as $file) {
                    $path = $file->store('keluhan/lampiran', 'public');
                    $lampiranFiles[] = [
                        'path' => $path,
                        'original_name' => $file->getClientOriginalName(),
                        'mime_type' => $file->getMimeType(),
                        'size' => $file->getSize()
                    ];
                }
            }

            // Create reply
            KeluhanBalasan::create([
                'keluhan_id' => $keluhan->id,
                'user_id' => Auth::id(),
                'pesan' => $request->pesan,
                'dari' => 'admin',
                'is_internal' => $isInternal,
                'lampiran' => $lampiranFiles
            ]);

            // Update keluhan
            $updateData = [
                'last_response_at' => now(),
                'last_response_by' => 'admin'
            ];

            // Update status berdasarkan kondisi
            if ($keluhan->status === 'buka') {
                $updateData['status'] = 'dalam_proses';
            } elseif ($request->boolean('auto_status_update', true) && !$request->boolean('is_internal', false)) {
                $updateData['status'] = 'menunggu_pelanggan';
            }

            $keluhan->update($updateData);

            DB::commit();

            return back()->with('success', 'Balasan berhasil dikirim.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Terjadi kesalahan saat mengirim balasan.']);
        }
    }

    /**
     * Update status keluhan (admin only)
     */
    public function updateStatus(Request $request, Keluhan $keluhan)
    {
        $request->validate([
            'status' => 'nullable|in:buka,dalam_proses,menunggu_pelanggan,selesai,ditutup',
            'prioritas' => 'nullable|in:rendah,normal,tinggi,urgent',
            'catatan' => 'nullable|string|max:500'
        ], [
            'status.in' => 'Status tidak valid.',
            'prioritas.in' => 'Prioritas tidak valid.',
            'catatan.max' => 'Catatan maksimal 500 karakter.'
        ]);

        try {
            DB::beginTransaction();

            $updateData = [];
            $logChanges = [];

            // Update status
            if ($request->filled('status') && $request->status !== $keluhan->status) {
                $oldStatus = $keluhan->status;
                $updateData['status'] = $request->status;
                $logChanges[] = "Status: {$oldStatus} → {$request->status}";

                // Auto-update last_response tracking
                if ($request->status === 'selesai' || $request->status === 'ditutup') {
                    $updateData['last_response_at'] = now();
                    $updateData['last_response_by'] = 'admin';
                }
            }

            // Update prioritas
            if ($request->filled('prioritas') && $request->prioritas !== $keluhan->prioritas) {
                $oldPrioritas = $keluhan->prioritas;
                $updateData['prioritas'] = $request->prioritas;
                $logChanges[] = "Prioritas: {$oldPrioritas} → {$request->prioritas}";
            }

            // Update keluhan
            $keluhan->update($updateData);

            // Log perubahan sebagai internal note jika ada perubahan
            if (!empty($logChanges)) {
                $logMessage = "Perubahan: " . implode(', ', $logChanges);
                if ($request->filled('catatan')) {
                    $logMessage .= "\nCatatan: " . $request->catatan;
                }

                KeluhanBalasan::create([
                    'keluhan_id' => $keluhan->id,
                    'user_id' => Auth::id(),
                    'pesan' => $logMessage,
                    'dari' => 'admin',
                    'is_internal' => true
                ]);
            }

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Status berhasil diperbarui.']);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan.'], 500);
        }
    }
}
