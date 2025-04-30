<?php

namespace App\Http\Controllers;
//namespace App\Http\Controllers\Exception;


use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Admin;
use Validator;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $fields = $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'age' => 'nullable',
            'contact' => 'required',
            'usertype' => 'required|in:admin,client',
            'national_id' => 'nullable',
            'gender' => 'nullable|in:male,female',
        ]);



        if($fields['usertype'] === 'admin') {
            $user = Admin::create([
                'firstname' => $fields['firstname'],
                'lastname' => $fields['lastname'],
                'email' => $fields['email'],
                'password' => Hash::make($fields['password']),
                'contact' => $fields['contact'],
                'usertype' => 'admin',

            ]);
        }else{
            $user =  User::create([
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'email' => $request->email,
                'password' => Hash::make($fields['password']),
                'age' => $request->age,
                'contact' => $request->contact,
                'usertype' => 'client',
                'national_id' => $request->national_id,
                'gender' => $request->gender,
            ]);
        }

        if ($user->save()) {
            $tokenResult = $user->createToken('Personal Access Token');
            $token = $tokenResult->plainTextToken;

            return response()->json([
                'message' => 'Successfully created user!',
                'accessToken' => $token,
                'user' => $user,
            ], 201);
        } else {
            return response()->json(['error' => 'Provide proper details']);
        }
    }

    public function login(Request $request)
{
    // Validate request input
    $fields = $request->validate([
        'email' => 'required|string|email',
        'password' => 'required|string',
        'remember_me' => 'boolean'
    ]);

    // Determine the 'remember me' flag
    $remember = $request->input('remember_me', false);

    // Search for user or admin based on email
    $user = User::where('email', $fields['email'])->first();
    $role = 'user';

    if (!$user) {
        $user = Admin::where('email', $fields['email'])->first();
        $role = 'admin';
    }

    // Check if user or admin is found and the password is correct
    if (!$user || !Hash::check($fields['password'], $user->password)) {
        return response(['message' => 'Invalid credentials'], 401);
    }

    // Create a token for the user or admin
    $token = $user->createToken('myAppToken')->plainTextToken;

    // Prepare the response
    $response = [
        'user' => $user,
        'token' => $token,
        'role' => $role,
    ];

    // Return the response
    return response($response, 200);
}


    public function forgotPassword(Request $request)
    {
        $fields = $request->validate([ //what was received
            'email' => 'required',
            'password' => 'required'
        ]);

        //check if email exists
        $user = User::where('email', $fields['email'])->first(); //first instance of email
        // dd($fields['password'],$user->password);
        //check password
        //if there is no such user or hash can't be verified return error message
        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'Bad Credentials'
            ], 401);
        }
        //if user exists and hash is ok go ahead and create token
        $token = $user->createToken('myAppToken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }
     public function logout(Request $request)
{
        auth()->user()->tokens()->delete();
        return response()->json(['message' => 'Successfully logged out']);
    }
}
