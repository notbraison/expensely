<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;


class GroupController extends Controller
{
    /**
     * Display a listing of the groups.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Fetch all groups
        $groups = Group::all();

        return response()->json([
            'message' => 'Fetched all groups successfully',
            'data' => $groups
        ]);
    }

    /**
     * Store a newly created group in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Create a new group
        $group = Group::create([
            'name' => $request->name,
        ]);

        return response()->json([
            'message' => 'Group created successfully',
            'data' => $group
        ]);
    }

    /**
     * Display the specified group.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group)
    {
        // Return the group details
        return response()->json([
            'message' => 'Fetched group details successfully',
            'data' => $group
        ]);
    }


    /**
     * Update the specified group in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Group $group)
    {
        // Validate the incoming request
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Update the group
        $group->update([
            'name' => $request->name,
        ]);

        // Return a simple success message
        return response()->json([
            'message' => 'Group updated successfully',
            'data' => $group
        ]);
    }

    /**
     * Remove the specified group from storage.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group)
    {
        // Delete the group
        $group->delete();

        // Redirect to the list of groups with success message
        return response()->json([
            'message' => 'Group deleted successfully'
        ]);
    }
}
