<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the dashboard page.
     */
    public function index()
    {
        // Anda bisa menambahkan data yang akan dikirim ke view di sini
        return view('admin.dashboard.index');
    }
}
