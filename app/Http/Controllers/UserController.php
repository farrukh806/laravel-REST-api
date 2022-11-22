<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    // Register a user
    public function register(Request $request){
        $form_fields = $request-> validate([
            'name' => 'required|string',
            'email' => ['required', 'email',  Rule::unique('users', 'email')],
            'password' => ['required', 'confirmed', ]
        ]);

        $user = User::create([
            'name'  => $form_fields['name'],
            'email' => $form_fields['email'],
            'password' => bcrypt($form_fields['password'])
        ]);

        $token = $user->createToken('apptoken');

        $response = [
            'user' => $user,
            'token' => $token -> plainTextToken
        ];
        return response($response, 201);
    }

    // Logout user
    public function logout(Request $request){
        auth() -> user() -> tokens() -> delete();

        return [
            'message' => 'Logged out successfully'
        ];
    }

    // Login a user
    public function login(Request $request){
        $form_fields = $request-> validate([
            'email' => ['required', 'email'],
            'password' => ['required' ]
        ]);

        // Check email if exists
        
        $user = User::where('email', $form_fields['email']) -> first();

        //Check password
        if(!$user || !Hash::check($form_fields['password'], $user->password)){
            return response([
                'message' => 'Bad credentials'
            ], 401);
        }

        $token = $user->createToken('apptoken');

        $response = [
            'user' => $user,
            'token' => $token -> plainTextToken
        ];
        return response($response, 201);
    }

}
