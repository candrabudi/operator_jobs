<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return view('users.index');
    }

    public function list()
    {
        $users = User::paginate(5);
        return response()->json($users);
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'phone_number' => 'required|string|max:15',
            'role' => 'required|in:superadmin,admin,operator_posting,operator_boosting,operator_both',
            'status' => 'required|boolean',
            'password' => 'required|string|min:8|confirmed',
        ]);

        try {
            $user = User::create([
                'full_name' => $request->input('full_name'),
                'username' => $request->input('username'),
                'password' => Hash::make($request->input('password')),
                'phone_number' => $request->input('phone_number'),
                'role' => $request->input('role'),
                'status' => $request->input('status'),
            ]);

            return response()->json([
                'message' => 'User successfully created',
                'data' => $user
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error occurred while creating user',
                'error' => $e->getMessage()
            ], 500);
        }
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
        $request->validate([
            'full_name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'phone_number' => 'required|string|max:255',
            'role' => 'required|string|in:superadmin,admin,operator_posting,operator_boosting,operator_both',
            'status' => 'required|boolean',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->full_name = $request->full_name;
        $user->username = $request->username;
        $user->phone_number = $request->phone_number;
        $user->role = $request->role;
        $user->status = $request->status;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        $user->save();

        return response()->json(['message' => 'User updated successfully']);
    }

    public function destroy($a)
    {
        User::where('id', $a)
            ->delete();

        return response()
            ->json([
                'status' => 'success',
                'code' => 200,
                'message' => 'Success destroy user',
            ]);
    }
}
