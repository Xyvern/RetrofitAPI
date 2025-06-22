<?php

namespace App\Http\Controllers;

use App\Models\Postcode;
use App\Models\User;
use App\Models\Topup;
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
        $email = $request->query('email');
        $password = $request->query('password');

        if (!$email || !$password) {
            return response()->json(['message' => 'Email and password are required'], 400);
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return response()->json(['message' => 'Invalid email format'], 400);
        }

        $user = User::where('email', $email)->first();
        
        if (!$user || !Hash::check($password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        return response()->json($user, 200);
    }

    public function createUser(Request $request)
    {
        if (User::where('email', $request->input('email'))->exists()) {
            return response()->json(['message' => 'Email is already registered.'], 409);
        }

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
            'postcode' => $request->input('postcode'),
            'pfp_url' => $request->input('profile_picture', '-'),
            'role' => $request->input('role', 1),
            'credit' => $request->input('credit', 0.00),
        ]);
        
        return response()->json($user, 201);
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::withTrashed()->where('userID', $id)->first();
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        
        $user->update([
            'name' => $request->input('name', $user->name),
            'password' => Hash::make($request->input('password', $user->password)),
            'phone' => $request->input('phone', $user->phone),
            'address' => $request->input('address', $user->address),
            'postcode' => $request->input('postcode', $user->postcode),
        ]);
        
        if ($request->input('status') == 'active') {
            $user->restore();
        } else {
            $user->delete();
        }
        
        return response()->json($user, 200);
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

    public function getCoordinates(Request $request)
    {
        $postcode = $request->query('postcode');
        $location = Postcode::where('postcodeId', $postcode)->first();
        if (!$location) {
            return response()->json(['message' => 'Postcode not found'], 404);
        }
        return response()->json($location, 200);
    }

    //employee
     public function getEmployees()
    {
        $employees = User::whereIn('role', [2, 4])->get();
        if ($employees->isEmpty()) {
            return response()->json(['message' => 'No employees found'], 404);
        }
        return response()->json($employees, 200);
    }
    public function updateEmployees(Request $request, $id)
    {
        $user = User::withTrashed()->where('userID', $id)->first();
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        $user->update([
            'name' => $request->input('name', $user->name),
            'email' => $request->input('email', $user->email)
        ]);
        return response()->json(['message' => 'User updated successfully'], 200);
    }

    public function getSnapToken(Request $request, $id) {
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;
        $orderId = rand(1000, 9999);
        $params = [
            'transaction_details' => [
                'order_id' =>  $orderId,
                'gross_amount' => $request->amount,
            ],
            'customer_details' => [
                'first_name' => 'customer',
                'email' => 'customer@example.com',
            ],
        ];

        $snapToken = \Midtrans\Snap::getSnapToken($params);
        Topup::create([
            'topupID' => $orderId,
            'userID' => $id,
            'amount' => $request->amount,
            'status' => 'pending',
            'snap_token' => $snapToken,
            'transdate' => now(),
        ]);


        $user = User::find($id); 
        if ($user) {
            $user->increment('credit', $request->amount); 
        }

        return response()->json(['token' => $snapToken, 'orderId' => $orderId]);
    }

    
}