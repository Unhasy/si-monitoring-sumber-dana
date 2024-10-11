<?php

namespace App\Http\Controllers;

use App\Models\MasterNomenklatur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class NomenklaturController extends Controller
{
    public function index()
    {
        $data = MasterNomenklatur::all();
        return view('admin.nomenklatur.index', compact('data'));
    }
    
    public function getData(Request $request)
    {
        $perPage = $request->get('perPage', 10); 
        $keyword = $request->get('keyword', '');
        $query = MasterNomenklatur::query();
        if (!empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                $q->where('kode_rekening', 'LIKE', '%' . $keyword . '%') 
                  ->orWhere('nomenklatur', 'LIKE', '%' . $keyword . '%'); 
            });
        }
        $data = $query->paginate($perPage);
        return response()->json($data);
    }
    public function store(Request $request)
    {
        $request->validate([
            'master_dasar_hukum_id' => 'required',
            'kategori' => 'required',
            'kode_rekening' => 'required',
            'nomenklatur' => 'required',
        ]);

        MasterNomenklatur::create([
            'master_dasar_hukum_id' => $request->master_dasar_hukum_id,
            'kategori' => $request->kategori,
            'kode_rekening' => $request->kode_rekening,
            'nomenklatur' => $request->nomenklatur,
            'user_pembuat' => 1,
        ]);

        // Mengembalikan respons JSON
        return response()->json([
            'message' => 'Nomenklatur created successfully.',
        ], 201);
    }

    public function edit($id)
    {
        $data = MasterNomenklatur::find($id);
        if (!$data) {
            return response()->json(['message' => 'Nomenklatur not found'], 404);
        }
        return response()->json($data);
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'master_dasar_hukum_id' => 'required',
            'kategori' => 'required',
            'kode_rekening' => 'required',
            'nomenklatur' => 'required',
        ]);
    
        $nomenklatur = MasterNomenklatur::find($id);
    
        if (!$nomenklatur) {
            return response()->json(['message' => 'Nomenklatur not found'], 404);
        }
    
        $nomenklatur->update([
            'master_dasar_hukum_id' => $request->master_dasar_hukum_id,
            'kategori' => $request->kategori,
            'kode_rekening' => $request->kode_rekening,
            'nomenklatur' => $request->nomenklatur,
        ]);
    
        return response()->json([
            'message' => 'Nomenklatur updated successfully.',
        ], 200); // 200 OK status
    }

    public function destroy($id)
    {
        $data = MasterNomenklatur::find($id);
    
        if (!$data) {
            return response()->json(['message' => 'Nomenklatur not found'], 404);
        }
    
        $data->delete();
    
        return response()->json(['message' => 'Nomenklatur deleted successfully.'], 200); // 200 OK status
    }
}
