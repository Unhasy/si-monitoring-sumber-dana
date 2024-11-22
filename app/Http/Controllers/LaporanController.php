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
    public function indexAdmin()
    {
        return view('admin.laporan.index-admin');
    }
    public function data(Request $request){
        $kode_opd = $request->get('kode_opd') ? $request->get('kode_opd') : Auth::user()->kode_opd;
        $renjaOPD = DB::table('renja_opd')
            ->where('opd_id', $kode_opd)
            ->first();
        $renjaOPDID = $renjaOPD->id;
        $query = "
                    select msd.kode_rekening, msd.keterangan, sum(rpar.pagu) as total_pagu, sum(rpar.realisasi) as total_realisasi from renja_pagu_anggaran_realisasi rpar 
                    join renja_data rd on rd.id = rpar.renja_data_id
                    join master_sumber_dana msd on msd.id = rpar.sumber_dana_id
                    where rd.renja_opd_id = '$renjaOPDID'
                    group by msd.kode_rekening, msd.keterangan
                    order by msd.kode_rekening
                ";
        $data = DB::select($query);
        
        $queryTotal = "
            select sum(pagu) pagu, sum(realisasi) realisasi from (
                select rd.*, mn.kategori, mn.nomenklatur, 
                (
                    select sum(pagu) from renja_pagu_anggaran_realisasi rpar 
                    where rpar.renja_data_id= rd.id COLLATE utf8mb4_unicode_ci
                ) as pagu,
                (
                    select sum(realisasi) from renja_pagu_anggaran_realisasi rpar 
                    where rpar.renja_data_id = rd.id COLLATE utf8mb4_unicode_ci
                ) as realisasi 
                    from renja_data rd
                    join master_nomenklatur mn on mn.kode_rekening = rd.kode_rekening COLLATE utf8mb4_unicode_ci
                    where 
                    renja_opd_id = '$renjaOPDID'
                    and rd.kategori_id in (1,2,5,6,7)
                    order by rd.kode_rekening
            ) total
        ";
        $total = DB::select($queryTotal);
        $response['data'] = $data;
        $response['total'] = $total;
        return response()->json($response);
    }
    public function dataAdmin(Request $request){
        $query = "
                    select msd.kode_rekening, msd.keterangan, sum(rpar.pagu) as total_pagu, sum(rpar.realisasi) as total_realisasi from renja_pagu_anggaran_realisasi rpar 
                    join renja_data rd on rd.id = rpar.renja_data_id
                    join master_sumber_dana msd on msd.id = rpar.sumber_dana_id
                    group by msd.kode_rekening, msd.keterangan
                    order by msd.kode_rekening
                ";
        $data = DB::select($query);
        
        $response['data'] = $data;
        return response()->json($response);
    }
}
