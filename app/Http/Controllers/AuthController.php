<?php

namespace App\Http\Controllers;

use App\Models\User;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $fields = $request->validate([
            'name' => "required|string",
            'email' => "required|string|unique:users,email",
            'password' => "required|string|confirmed",
        ]);
        $user =  User::create([
            'name' => $fields["name"],
            'email' => $fields["email"],
            'password' => bcrypt($fields['password']),
        ]);
        $token = $user->createToken('myapptoken')->plainTextToken;
        $response = [
            'user' => $user,
            'token' => $token
        ];
        return response($response, 201);
        
    }
    public function login(Request $request)
    {
        $field = $request->validate([
            'email' => 'required|string',
            'password'  => 'required|string'
        ]);
        
        // check email
        $user = User::where('email', $field['email'])->first();
        // check password
        if(!$user || !Hash::check($field['password'], $user->password)){
            return response([
                'message' =>  'Somthing Wrong!!'
            ]);
        }else{
            
            $token = $user->createToken('myapptoken')->plainTextToken;
            $response = [
                'user' => $user,
                'token' => $token
            ];
            return response($response, 201);
        }

        
    }

    public function logout(Request $request)
    {
        auth()->user()->Tokens()->delete();
        return[
            'message' => 'Logout'
        ];
    }
}
