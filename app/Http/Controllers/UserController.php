<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index()
    {
        $users = DB::table('users')->get();
        return response()->json([
            "message" => 'success',
            "data" => $users
        ]);
    }

    public function create()
    {
        return view('create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name'   => 'required|string|max:255',
            'last_name'    => 'required|string|max:255',
            'email'        => 'required|email|unique:users,email',
            'password_hash' => 'required|string|min:8',
            'role'         => 'required|string',
            'is_active'    => 'required|boolean',
            'is_verified'  => 'required|boolean'
        ]);

        $user = User::create([
            'uid' => (string) Str::uuid(),
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'username' => $request->username,
            'email' => $validated['email'],
            'password_hash' => Hash::make($validated['password_hash']),
            'role' => "STUDENT",
            "is_active" => "true",
            "is_verified" => "true",
        ]);

        return response()->json([
            'message' => 'User created successfully',
            'data' => $user
        ], 201);
    }


    public function show($id)
    {
        $user = User::where('uid', $id)->firstOrFail();
        return response()->json([
            "message" => 'success',
            "data" => $user
        ]);
    }

    public function edit($id)
    {
        $user = User::where('uid', $id)->firstOrFail();

        if (!$user) {
            return response()->json([
                'message' => 'User not found',
            ], 404);
        }

        return response()->json([
            'message' => 'success',
            'data' => $user
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'first_name'   => 'required|string|max:255',
            'last_name'    => 'required|string|max:255',
            'email'        => 'required|email|unique:users,email',
            'password_hash' => 'required|string|min:8',
            'role'         => 'required|string',
            'is_active'    => 'required|boolean',
            'is_verified'  => 'required|boolean'
        ]);

        $user = User::where('uid', $id)->firstOrFail();

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return response()->json([
            'message' => 'User updated successfully',
            'data' => $user
        ]);
    }

    public function delete(){
        
    }
}
