<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a list of all users
     */
    public function readUsers(Request $request)
    {
        //display all users
        $user = User::all();

        if ($user) {
            return response()->json($user);
        } else {
            return response("No user found");
        }
    }

    /**
     * create a new user
     */
    public function createUser(Request $request)
    {
        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'age' => 'required|integer',
            'contact' => 'required',
            'national_id' => 'required',
            'gender' => 'required|in:male,female',
        ]);

        $user = User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'age' => $request->age,
            'contact' => $request->contact,
            'usertype' => 'client',
            'national_id' => $request->national_id,
            'gender' => $request->gender,
        ]);

        return response()->json($user, 201);
    }

    //read a single user 
    public function readUser($user_id)
    {
        // Validate that the id is an integer
        if (!is_numeric($user_id) || intval($user_id) <= 0) {
            return response()->json(['error' => 'Invalid user ID'], 422);
        }

        // Find the user by ID
        $user = User::find($user_id);

        // Check if the user exists
        if ($user) {
            // Return the user data as JSON
            return response()->json($user);
        } else {
            // Return an error response if the user does not exist
            return response()->json(['error' => 'User not found'], 404);
        }
    }

    public function updateUser(Request $request)
{
    $request->validate([
        'user_id' => 'required|exists:users,user_id',
        'firstname' => 'required|string|max:255',
        'lastname' => 'required|string|max:255',
        'email' => 'required|email',
        'age' => 'required|integer',
        'gender' => 'required|string',
        'national_id' => 'required|string|max:255',
        'contact' => 'required|string|max:255',
        'usertype' => 'required|string|max:255'
    ]);

    try {
        $user = User::find($request->user_id);

        if ($user) {
            // Update the user's details
            $user->firstname = $request->firstname;
            $user->lastname = $request->lastname;
            $user->email = $request->email;
            $user->age = $request->age;
            $user->gender = $request->gender;
            $user->national_id = $request->national_id;
            $user->contact = $request->contact;
            $user->usertype = $request->usertype;

            $user->save();

            return response()->json(['message' => 'User updated successfully', 'user' => $user], 200);
        } else {
            return response()->json(['message' => 'User not found'], 404);
        }
    } catch (\Exception $e) {
        return response()->json(['message' => 'An error occurred', 'error' => $e->getMessage()], 500);
    }
}


    public function deleteUser($id)
    {
        $user = User::where('user_id', $id)->first();

        if ($user) {
            $deletedUser = $user;
            $user->delete();

            return response()->json([
                'message' => 'User has been deleted',
                'user' => $deletedUser
            ], 200);
        } else {
            return response()->json([
                'message' => 'Delete unsuccessful, no such user exists'
            ], 404);
        }
    }
}
