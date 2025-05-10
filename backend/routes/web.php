<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\GroupMembersController;
use App\Models\GroupMember;

Route::middleware('web')->group(function () {
    Route::group(['prefix' => 'auth'], function () {
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/forgotPassword', [AuthController::class, 'forgotPassword']);

        Route::middleware('auth:sanctum')->group(function () {
            Route::get('/logout', [AuthController::class, 'logout']);
        });
    });
});

// For web routes

//groups
Route::resource('groups', GroupController::class);

//Group members

// Fetch members of a group
Route::prefix('groups/{group}')->group(function () {
    // Fetch members of the group
    Route::get('members', [GroupMembersController::class, 'index'])->name('group.members.index');

    // Add a member to the group
    Route::post('members', [GroupMembersController::class, 'store'])->name('group.members.store');

    // Get details of a specific member
    Route::get('members/{groupMember}', [GroupMembersController::class, 'show'])->name('group.members.show');

    //Get details of a specific member
    Route::get('members/{groupMember}', [GroupMembersController::class, 'show'])->name('group.members.show');

    // Update a group member's role
    Route::put('members/{groupMember}', [GroupMembersController::class, 'update'])->name('group.members.update');

    // Remove a group member
    Route::delete('members/{groupMember}', [GroupMembersController::class, 'destroy'])->name('group.members.destroy');

});

