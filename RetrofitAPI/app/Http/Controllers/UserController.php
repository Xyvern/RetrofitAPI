<?php

namespace App\Http\Controllers;

use App\Models\Postcode;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function getAllUsers()
    {
        $users = User::all();
        return response()->json($users,200);
    }

    public function getUserById($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        return response()->json($user, 200);
    }

    public function getUserByEmail($email)
    {
        $user = User::where('email', $email)->first();
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        return response()->json($user, 200);
    }

    public function login(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        $user = User::where('email', $email)->first();
        
        if (!$user) {
            return response()->json(['message' => 'Email not registered'], 404);
        }

        if (!Hash::check($password, $user->password)) {
            return response()->json(['message' => 'Incorrect password'], 401);
        }

        return response()->json([
            'message' => 'Login successful',
            'user' => $user
        ], 200);
    }

    public function createUser(Request $request)
    {

        if (User::where('email', $request->input('email'))->exists()) {
            return response()->json(['message' => 'Email is already registered.'], 409);
        }

        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
            'postcode' => $request->input('postcode'),
            // 'profile_picture' => $request->input('profile_picture', '-'),
            'pfp_url' => $request->input('profile_picture', '-'),
            'role' => $request->input('role',1),
            'credit' => $request->input('credit', 0.00),
        ]);
        return response()->json(['message' => 'User created successfully'], 201);
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::withTrashed()->where('userID', $id)->first();
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        $user->update([
            'name' => $request->input('name', $user->name),
            'email' => $request->input('email', $user->email),
        ]);
        if ($request->input('status') == 'active') {
            $user->restore();
        }else{
            $user->delete();
        }
        return response()->json(['message' => 'User updated successfully'], 200);
    }

    public function deleteUser($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        $user->delete();
        return response()->json(['message' => 'User deleted successfully'], 200);
    }

    public function getPostCode(){
        $postcodes = Postcode::all();
        if ($postcodes->isEmpty()) {
            return response()->json(['message' => 'No postcodes found'], 404);
        }
        return response()->json($postcodes, 200);
    }
     
}