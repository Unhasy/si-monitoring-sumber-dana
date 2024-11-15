<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;



class RealisasiController extends Controller
{
    /**
     * Display the dashboard page.
     */
    public function index()
    {
        $kode_opd = Auth::user()->kode_opd;
        $renjaOPD = DB::table('renja_opd')
            ->where('opd_id', $kode_opd)
            ->first();
        $renjaOPDID = $renjaOPD->id;
        $query = "
                    select rd.*, mn.kategori, mn.nomenklatur, 
                    (
                        select sum(pagu) from renja_pagu_anggaran_realisasi rpar 
                        where rpar.renja_data_id= rd.id COLLATE utf8mb4_unicode_ci
                    ) as pagu from renja_data rd
                    join master_nomenklatur mn on mn.kode_rekening = rd.kode_rekening COLLATE utf8mb4_unicode_ci
                    where 
                    renja_opd_id = '$renjaOPDID'
                    and rd.kategori_id in (1,2,5,6,7)
                    order by rd.kode_rekening
                ";
        $data = DB::select($query);
        return view('admin.realisasi.index', compact('data'));
    }
}
