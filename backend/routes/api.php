<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FloorController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ReportController;


// api.php


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// Protected routes
Route::middleware(['auth:sanctum'])->group(function () {
    // User routes
    Route::get('/user', [UserController::class, 'readUsers']);
    Route::post('/user', [UserController::class, 'createUser']);
    Route::get('/user/{id}', [UserController::class, 'readUser']);
    Route::put('/user/{id}', [UserController::class, 'updateUser']);
    Route::delete('/user/{id}', [UserController::class, 'deleteUser']);

    // Admin routes (Protected with admin-specific middleware)
    Route::middleware('is-admin')->group(function () {
        Route::get('/admin/index', [AdminController::class, 'index']);
        Route::post('/admin/store', [AdminController::class, 'store']);
        Route::get('/admin/show/{id}', [AdminController::class, 'show']);
        Route::put('/admin/update/{id}', [AdminController::class, 'update']);
        Route::delete('/admin/destroy/{id}', [AdminController::class, 'destroy']);
    });
});


// User Routes
Route::get('/users', [UserController::class, 'readUsers']);
Route::post('/user', [UserController::class, 'createUser']);
Route::get('/user/{id}', [UserController::class, 'readUser']);
Route::put('/user/{id}', [UserController::class, 'updateUser']);
Route::delete('/user/{id}', [UserController::class, 'deleteUser']);

Route::prefix('admin')->group(function () {
    Route::get('/index', [AdminController::class, 'index']); // List all admins
    Route::post('/store', [AdminController::class, 'store']); // Create new admin
    Route::get('/show/{id}', [AdminController::class, 'show']); // Show admin by ID
    Route::put('/update/{id}', [AdminController::class, 'update']); // Update admin by ID
    Route::delete('/destroy/{id}', [AdminController::class, 'destroy']); // Delete admin by ID
});


// Building Routes
Route::get('/buildings', [BuildingController::class, 'readBuildings']);
Route::post('/building', [BuildingController::class, 'createBuilding']);
Route::get('/building/{id}', [BuildingController::class, 'readBuilding']);
Route::put('/building/{id}', [BuildingController::class, 'updateBuilding']);
Route::delete('/building/{id}', [BuildingController::class, 'deleteBuilding']);

//Floors
Route::get('/floors/building/{building_id}', [FloorController::class, 'getFloorsByBuilding']);// Retrieve all floors for a specific building
Route::post('/floors', [FloorController::class, 'createfloor']);// Create a new floor
Route::get('/floors/{floor_id}', [FloorController::class, 'readfloor']);// Get a specific floor by its ID
Route::put('/floors/{floor_id}', [FloorController::class, 'updatefloor']);// Update a specific floor by its ID
Route::delete('/floors/{floor_id}', [FloorController::class, 'deletefloor']);// Delete a specific floor by its ID

//rooms
Route::get('/rooms', [RoomController::class, 'getRooms']);// Retrieve all rooms
Route::post('/rooms', [RoomController::class, 'addRoom']); // Add a new room
Route::get('room/{id}', [RoomController::class, 'getRoom']); // Retrieve a specific room
Route::put('room/{id}', [RoomController::class, 'updateRoom']); // Update a specific room
Route::delete('room/{id}', [RoomController::class, 'deleteRoom']); // Delete a specific room
Route::get('/rooms/floor/{floor_id}', [RoomController::class, 'getRoomsByFloor']); // Fetch rooms associated with a specific floor
Route::get('/rooms/vacant', [RoomController::class, 'getVacantRooms']); // Fetch all vacant rooms
Route::get('/user/{user_id}/rented-rooms', [RoomController::class, 'getRentedRoomsByUser']);//fetch all rooms that a user has rented based on their user_id.


//booking
Route::post('/book', [BookingController::class, 'store']);
Route::get('/bookings/user/{user_id}', [BookingController::class, 'index']); // Fetch bookings for a specific user
Route::get('/bookings', [BookingController::class, 'index']); // Fetch all bookings
Route::get('/bookings/{id}', [BookingController::class, 'show']); // Fetch a specific booking by ID
Route::delete('/bookings/{id}', [BookingController::class, 'destroy']);//delete a booking


//payments
Route::post('/payments', [PaymentController::class, 'store']); // Create a new payment
Route::get('/payments/{id}', [PaymentController::class, 'show']); // Get payment details
Route::get('/payments', [PaymentController::class, 'showAll']); // Get all payment details
Route::put('/payments/{id}', [PaymentController::class, 'update']); // Update payment status
Route::post('/simulate-payment', [PaymentController::class, 'simulatePayment']);
Route::delete('/payments/{id}', [PaymentController::class, 'destroy']);
Route::get('/user/{user_id}/payment-history', [PaymentController::class, 'getPaymentHistory']);//payment by user id


// Room update for 'booked' status AFTER payment is confirmed

Route::put('/room/{id}/status', [RoomController::class, 'updateRoomStatus']);


//Comments
Route::post('/comments', [CommentController::class, 'createComment']);
Route::get('/comments', [CommentController::class, 'index']);
Route::get('/admin-comments', [CommentController::class, 'getAdminComments']);//comments by admins
Route::get('/comments/{id}', [CommentController::class, 'edit']);
Route::put('/comments/{id}', [CommentController::class, 'update']);
Route::delete('/comments/{id}', [CommentController::class, 'destroy']);
Route::get('/comments/user/{userId}', [CommentController::class, 'getCommentsByUserId']);
Route::get('/comments/room/{roomId}', [CommentController::class, 'getCommentsByRoomId']);

//Reports for Admins
Route::get('/reports/booking-trends', [ReportController::class, 'getBookingTrends']);
Route::get('/reports/occupancy-rates', [ReportController::class, 'getOccupancyRates']);
Route::get('/reports/revenue', [ReportController::class, 'getRevenue']);
Route::get('/reports/user-demographics', [ReportController::class, 'getUserDemographics']);






