<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Nette\Utils\Json;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return response()->json([
            "message" => 'success',
            "data" => $users
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'uid' => uniqid(),
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
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
        $user = User::where('uid', $id)->first();

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
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id . ',uid',
            'password' => 'required|string|min:8',
        ]);

        $user = User::where('uid', $id)->firstOrFail();

        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $user->update($validated);

        return response()->json([
            'message' => 'User updated successfully',
            'data' => $user
        ]);
    }
}
