<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\RenjaPaguAnggaranRealisasi;


class RealisasiController extends Controller
{
    /**
     * Display the dashboard page.
     */
    public function index()
    {
        return view('admin.realisasi.index');
    }
    public function indexAdmin()
    {
        return view('admin.realisasi.index-admin');
    }
    public function data(Request $request){
        $kode_opd = $request->get('kode_opd') ? $request->get('kode_opd') : Auth::user()->kode_opd;
        $renjaOPD = DB::table('renja_opd')
            ->where('opd_id', $kode_opd)
            ->first();
        $renjaOPDID = $renjaOPD->id;
        $query = "
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
                ";
        $data = DB::select($query);
        $dataArray = [];
        foreach ($data as $row) {
            $pagu = 0;
            $realisasi = 0;

            if($row->kategori=="SUB KEGIATAN"){
                $pagu = (int)$row->pagu;
                $realisasi = (int)$row->realisasi;
            } else {
                foreach ($data as $row2) {
                    if($row2->kategori=="SUB KEGIATAN"){
                        $paguSub = $row2->pagu;
                        $realisasiSub = $row2->realisasi;
                        $lenKodeRekeningParent = strlen($row->kode_rekening);
                        if($row->kode_rekening ==  substr($row2->kode_rekening, 0, $lenKodeRekeningParent)) {
                            $pagu += $paguSub;
                            $realisasi += $realisasiSub;
                        }
                    }       
                }
            }
            $dataArray[] = [
                'id' => $row->id,
                'renja_opd_id' => $row->renja_opd_id,
                'kode_rekening' => $row->kode_rekening,
                'kategori_id' => $row->kategori_id,
                'keterangan' => $row->keterangan,
                'kategori' => $row->kategori,
                'nomenklatur' => $row->nomenklatur,
                'pagu' => (int)$pagu,
                'realisasi' => (int)$realisasi
            ];
        }
        return response()->json($dataArray);
    }
    
    public function dataAdmin(Request $request){
        $query = "
                    select mo.kode_opd, nama_opd,
                    (
                        select sum(rpar.pagu) from renja_opd ro 
                        join renja_data rd on rd.renja_opd_id = ro.id
                        join renja_pagu_anggaran_realisasi rpar on rpar.renja_data_id = rd.id
                        where ro.opd_id = mo.kode_opd COLLATE utf8mb4_unicode_ci
                    ) pagu,
                    (
                        select sum(rpar.realisasi) from renja_opd ro 
                        join renja_data rd on rd.renja_opd_id = ro.id
                        join renja_pagu_anggaran_realisasi rpar on rpar.renja_data_id = rd.id
                        where ro.opd_id = mo.kode_opd COLLATE utf8mb4_unicode_ci
                    ) realisasi
                    from master_opd mo 
                    order by mo.kode_opd asc
                ";
        $data = DB::select($query);
        return response()->json($data);
    }

    public function sumberdana($id)
    {
        $data = DB::table('renja_pagu_anggaran_realisasi')
        ->join('master_sumber_dana', 'master_sumber_dana.id', '=', 'renja_pagu_anggaran_realisasi.sumber_dana_id')
        ->select('renja_pagu_anggaran_realisasi.*', 'master_sumber_dana.kode_rekening', 'master_sumber_dana.keterangan')
        ->where('renja_data_id', $id)
        ->get();
        if (!$data) {
            return response()->json(['message' => 'Sumberdana not found'], 404);
        }
        return response()->json($data);
    }

    public function store(Request $request)
    {
        foreach ($request->sumberdanas as $row) {
           if($row['realisasi']!=null){
                $dana = RenjaPaguAnggaranRealisasi::find($row['id']);
                $dana->update([
                    'realisasi' => $row['realisasi'],
                ]); 
           }
        }
        // Mengembalikan respons JSON
        return response()->json([
            'message' => 'Realisasi berhasil di perbarui.',
        ], 201);
    }
}
