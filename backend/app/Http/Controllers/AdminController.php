<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|min:8|confirmed',
            'contact' => 'required',
            
        ]);

        $admin = Admin::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'password' => bcrypt($request->password), // Hash the password
            'contact' => $request->contact,
            'usertype'=>'admin'
            
        ]);

        return response()->json($admin, 201);
    }

    public function index()
    {
        $admins = Admin::all();
        return response()->json($admins);
    }

    public function show($id)
    {
        $admin = Admin::find($id);
        if ($admin) {
            return response()->json($admin);
        }
        return response()->json(['message' => 'Admin not found'], 404);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'firstname' => 'sometimes|required',
            'lastname' => 'sometimes|required',
            'email' => 'sometimes|required|email',
            'password' => 'sometimes|required|min:8|confirmed',
            'contact' => 'sometimes|required',
            'address' => 'sometimes|required',
        ]);

        $admin = Admin::find($id);
        if ($admin) {
            if ($request->has('firstname')) $admin->firstname = $request->firstname;
            if ($request->has('lastname')) $admin->lastname = $request->lastname;
            if ($request->has('email')) $admin->email = $request->email;
            if ($request->has('password')) $admin->password = bcrypt($request->password);
            if ($request->has('contact')) $admin->contact = $request->contact;
            if ($request->has('address')) $admin->address = $request->address;

            $admin->save();
            return response()->json($admin);
        }
        return response()->json(['message' => 'Admin not found'], 404);
    }

    public function destroy($id)
    {
        $admin = Admin::find($id);
        if ($admin) {
            $admin->delete();
            return response()->json(['message' => 'Admin deleted successfully']);
        }
        return response()->json(['message' => 'Admin not found'], 404);
    }
}
