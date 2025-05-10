<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\GroupMembersController;
use App\Models\GroupMember;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\AIController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\CalculatorController;




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

//google oauth service
Route::get('/google/callback', [GoogleController::class, 'handleGoogleCallback']);



//Friends

use App\Http\Controllers\FriendshipController;

// Send a friend request
Route::post('/friends/{friendId}/request', [FriendshipController::class, 'sendRequest'])->middleware('auth');

// Accept or decline a friend request
Route::post('/friends/{friendshipId}/respond', [FriendshipController::class, 'respondToRequest'])->middleware('auth');

// View all friends of the logged-in user
Route::get('/friends', [FriendshipController::class, 'viewFriends'])->middleware('auth');

// Remove a friend
Route::delete('/friends/{friendshipId}', [FriendshipController::class, 'removeFriend'])->middleware('auth');


//groups
// Protecting the store and index method     middleware
// to ensure that only authenticated users can access them
Route::middleware('auth')->group(function () {
    Route::get('/groups', [GroupController::class, 'index']);
    Route::post('/groups', [GroupController::class, 'store']);
});
// Fetch groups by user ID (where userId is passed as a parameter)
Route::get('/api/groups/user/{userId}', [GroupController::class, 'getGroupsByUser']);

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

//payment methods
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/payment-methods', [PaymentMethodController::class, 'addPaymentMethod']);
    Route::get('/payment-methods', [PaymentMethodController::class, 'getPaymentMethods']);
    Route::delete('/payment-methods/{id}', [PaymentMethodController::class, 'removePaymentMethod']);
});

//payments

Route::middleware('auth:sanctum')->get('/payments', [PaymentController::class, 'index']);
Route::middleware('auth:sanctum')->get('/payments/{paymentId}', [PaymentController::class, 'show']);



//Notifications;

// Fetch all notifications for the logged-in user
Route::get('/notifications', [NotificationController::class, 'index'])->middleware('auth:sanctum');

// Mark a specific notification as read
Route::patch('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->middleware('auth:sanctum');

// Mark all notifications as read
Route::patch('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->middleware('auth:sanctum');

// Delete a notification
Route::delete('/notifications/{id}', [NotificationController::class, 'delete'])->middleware('auth:sanctum');



// Route for getting AI insights
Route::post('/ai-insights', [AIController::class, 'getInsights'])->middleware('auth:sanctum');


//transactions
Route::middleware('auth:sanctum')->get('/transactions', [TransactionController::class, 'index']);

//Calculator


// Route for calculating expense split
Route::middleware('auth:sanctum')->post('/expense-split', [CalculatorController::class, 'calculateExpenseSplit']);

// Route for tracking budget
Route::middleware('auth:sanctum')->post('/track-budget', [CalculatorController::class, 'trackBudget']);

// Route for calculating savings goal
Route::middleware('auth:sanctum')->post('/calculate-savings', [CalculatorController::class, 'calculateSavingsGoal']);

// Route for storing a new savings goal
Route::middleware('auth:sanctum')->post('/store-savings-goal', [CalculatorController::class, 'storeSavingsGoal']);
