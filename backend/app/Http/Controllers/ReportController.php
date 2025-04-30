<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking; // Make sure to import your Booking model
use App\Models\User; // Import User model
use Carbon\Carbon;

class ReportController extends Controller
{
    // Get booking trends over time
    public function getBookingTrends()
    {
        $trends = Booking::selectRaw('DATE(created_at) as date, COUNT(*) as bookings')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return response()->json($trends);
    }

    // Get room occupancy rates
    public function getOccupancyRates()
    {
        $occupancyRates = Booking::selectRaw('room_id, COUNT(*) as bookings')
            ->groupBy('room_id')
            ->with('room') // Make sure to define a relationship in Booking model
            ->get();

        return response()->json($occupancyRates);
    }

    // Get revenue generated from bookings
    public function getRevenue()
    {
        $revenue = Booking::selectRaw('SUM(rate) as total_revenue')
            ->with('room') // Make sure to define a relationship in Booking model
            ->first();

        return response()->json(['total_revenue' => $revenue->total_revenue]);
    }

    // Get user demographics
    public function getUserDemographics()
    {
        $demographics = User::selectRaw('gender, COUNT(*) as count')
            ->groupBy('gender')
            ->get();

        return response()->json($demographics);
    }
}
