<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AksesPelangganController extends Controller
{
    public function index()
    {
        return view('pelanggan.index');
    }
}
