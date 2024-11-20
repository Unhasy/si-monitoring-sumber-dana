<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\RenjaPaguAnggaranRealisasi;


class LaporanController extends Controller
{
    /**
     * Display the dashboard page.
     */
    public function index()
    {
        return view('admin.laporan.index');
    }
}
