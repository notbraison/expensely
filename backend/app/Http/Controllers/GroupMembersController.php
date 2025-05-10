<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GroupMember;
use App\Models\Group;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class GroupMembersController extends Controller
{
    //
     /**
     * Display a listing of the members of the group.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function index(Group $group)
    {
        // Fetch all members of the group
        $members = $group->members; // Assuming 'members' relationship is set in the Group model

        // Return a message with the list of members
        return response()->json([
            'message' => 'Fetched group members successfully',
            'data' => $members
        ]);
    }

    /**
     * Store a newly created member in the group.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Group $group)
    {
        // Validate the request
        $request->validate([
            'user_id' => 'required|exists:users,id', // User must exist in the users table
            'role' => 'required|in:owner,member,viewer', // Role should be one of the allowed values
        ]);

        // Check if the user is already a member of the group
        $existingMember = GroupMember::where('group_id', $group->id)
                                     ->where('user_id', $request->user_id)
                                     ->first();

        if ($existingMember) {
            return response()->json(['message' => 'User is already a member of this group'], 400);
        }

        // Add the member to the group
        $member = GroupMember::create([
            'group_id' => $group->id,
            'user_id' => $request->user_id,
            'role' => $request->role,
        ]);

        return response()->json([
            'message' => 'Member added to group successfully',
            'data' => $member
        ]);
    }

    /**
     * Display the specified member's details in the group.
     *
     * @param  \App\Models\Group  $group
     * @param  \App\Models\GroupMember  $groupMember
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group, GroupMember $groupMember)
    {
        // Return member details
        return response()->json([
            'message' => 'Fetched member details successfully',
            'data' => $groupMember
        ]);
    }

    /**
     * Update the specified member's role in the group.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Group  $group
     * @param  \App\Models\GroupMember  $groupMember
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Group $group, GroupMember $groupMember)
    {
        // Validate the role
        $request->validate([
            'role' => 'required|in:owner,member,viewer',
        ]);

        // Update the member's role
        $groupMember->update([
            'role' => $request->role,
        ]);

        return response()->json([
            'message' => 'Member role updated successfully',
            'data' => $groupMember
        ]);
    }

    /**
     * Remove the specified member from the group.
     *
     * @param  \App\Models\Group  $group
     * @param  \App\Models\GroupMember  $groupMember
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group, GroupMember $groupMember)
    {
        // Ensure the group member exists
        if ($groupMember) {
            $groupMember->delete();

            return response()->json([
                'message' => 'Member removed from group successfully'
            ]);
        }

        return response()->json([
            'message' => 'Member not found'
        ], 404);
    }
}
