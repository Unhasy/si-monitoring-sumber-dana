<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\MasterOpd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.user.index', compact('users'));
    }
    
    public function getData(Request $request)
    {
        $perPage = $request->get('perPage', 10); 
        $keyword = $request->get('keyword', '');
        $query = User::query();
        if (!empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'LIKE', '%' . $keyword . '%') 
                  ->orWhere('email', 'LIKE', '%' . $keyword . '%'); 
            });
        }
        $users = $query->paginate($perPage);
        return response()->json($users);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'role' => 'required',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'kode_opd' => $request->kode_opd,
            'password' => Hash::make($request->password), // Hash the password
        ]);

        // Mengembalikan respons JSON
        return response()->json([
            'message' => 'User created successfully.',
        ], 201);
    }

    public function edit($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        return response()->json($user);
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required',
        ]);
    
        $user = User::find($id);
    
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
    
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'kode_opd' => $request->kode_opd,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);
    
        return response()->json([
            'message' => 'User updated successfully.',
        ], 200); // 200 OK status
    }

    public function destroy($id)
    {
        $user = User::find($id);
    
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
    
        $user->delete();
    
        return response()->json(['message' => 'User deleted successfully.'], 200); // 200 OK status
    }

    public function opd()
    {
        $opd = MasterOpd::all();
        return response()->json($opd);
    }
}
