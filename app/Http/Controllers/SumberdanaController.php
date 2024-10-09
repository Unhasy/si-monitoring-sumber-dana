<?php

namespace App\Http\Controllers;

use App\Models\MasterSumberDana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SUmberdanaController extends Controller
{
    public function index()
    {
        $data = MasterSumberDana::all();
        return view('admin.sumberdana.index', compact('data'));
    }
    
    public function getData(Request $request)
    {
        $perPage = $request->get('perPage', 10); 
        $keyword = $request->get('keyword', '');
        $query = MasterSumberDana::query();
        if (!empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                $q->where('kode_rekening', 'LIKE', '%' . $keyword . '%') 
                  ->orWhere('keterangan', 'LIKE', '%' . $keyword . '%'); 
            });
        }
        $data = $query->paginate($perPage);
        return response()->json($data);
    }
    public function store(Request $request)
    {
        $request->validate([
            'kode_rekening' => 'required',
            'keterangan' => 'required',
        ]);

        MasterSumberDana::create([
            'kode_rekening' => $request->kode_rekening,
            'keterangan' => $request->keterangan,
            'user_pembuat' => 1,
        ]);

        // Mengembalikan respons JSON
        return response()->json([
            'message' => 'Sumberdana created successfully.',
        ], 201);
    }

    public function edit($id)
    {
        $data = MasterSumberDana::find($id);
        if (!$data) {
            return response()->json(['message' => 'Sumberdana not found'], 404);
        }
        return response()->json($data);
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'kode_rekening' => 'required',
            'keterangan' => 'required',
        ]);
    
        $sumberdana = MasterSumberDana::find($id);
    
        if (!$sumberdana) {
            return response()->json(['message' => 'Sumberdana not found'], 404);
        }
    
        $sumberdana->update([
            'kode_rekening' => $request->kode_rekening,
            'keterangan' => $request->keterangan,
        ]);
    
        return response()->json([
            'message' => 'Sumberdana updated successfully.',
        ], 200); // 200 OK status
    }

    public function destroy($id)
    {
        $data = MasterSumberDana::find($id);
    
        if (!$data) {
            return response()->json(['message' => 'Sumberdana not found'], 404);
        }
    
        $data->delete();
    
        return response()->json(['message' => 'Sumberdana deleted successfully.'], 200); // 200 OK status
    }
}
