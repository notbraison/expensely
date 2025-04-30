<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Floor;
use App\Models\building;

class FloorController extends Controller
{
     /**
     * Display a list of all floors
     */
    public function getFloorsByBuilding($building_id)
{
    if (!is_numeric($building_id) || intval($building_id) <= 0) {
        return response()->json(['error' => 'Invalid building ID'], 422);
    }

    $building = Building::find($building_id);
    if (!$building) {
        return response()->json(['message' => 'Building not found'], 404);
    }

    $floors = Floor::where('building_id', $building_id)->get();
    $maxFloors = $building->number_of_floors;
    $currentFloorCount = $floors->count();
    $remainingFloors = $maxFloors - $currentFloorCount;

    return response()->json([
        'building' => $building,
        'floors' => $floors,
        'remaining_floors' => $remainingFloors,
        'next_floor_number' => $currentFloorCount + 1
    ], 200);
}



    /**
     * create a new floor
     */
    public function createfloor(Request $request)
    {
        // Validate input including building_id, floor_number, and number_of_rooms
        $validatedData = $request->validate([
            'building_id' => 'required|exists:buildings,building_id', // Ensure the building exists
            'floor_number' => 'required|integer',
            'number_of_rooms' => 'required|integer|min:1', // Require at least 1 room
        ]);
    
        try {
            $building = Building::findOrFail($validatedData['building_id']);

            // Check the current number of floors in the building
        $currentFloorCount = Floor::where('building_id', $building->building_id)->count();

        if ($currentFloorCount >= $building->number_of_floors) {
            return response()->json(['message' => 'Maximum number of floors reached for this building.'], 400);
        }

            // Create the floor with validated data
            $floor = Floor::create([
                'building_id' => $validatedData['building_id'],
                'floor_number' => $validatedData['floor_number'],
                'number_of_rooms' => $validatedData['number_of_rooms'],
            ]);
    
            return response()->json([
                'message' => 'Floor created successfully!',
                'floor' => $floor
            ], 201);
    
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to create floor!',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    

    //read a single floor 
    public function readfloor($floor_id)
    {// Validate that the id is an integer
        if (!is_numeric($floor_id) || intval($floor_id) <= 0) {
            return response()->json(['error' => 'Invalid floor ID'], 422);
        }

        // Find the floor by ID
        $floor = Floor::find($floor_id);

        // Check if the floor exists
        if ($floor) {
            // Return the floor data as JSON
            return response()->json($floor);
        } else {
            // Return an error response if the floor does not exist
            return response()->json(['error' => 'floor not found'], 404);
        }
    }

    public function updatefloor(Request $request)
    {
        // Validate input for updating the floor
        $validatedData = $request->validate([
            'floor_id' => 'required|exists:floors,floor_id', // Ensure floor exists
            'building_id' => 'required|exists:buildings,building_id', // Ensure the building exists
            'floor_number' => 'required|integer',
            'number_of_rooms' => 'required|integer|min:1', // Require at least 1 room
        ]);
    
        try {
            // Find the floor by floor_id
            $floor = Floor::find($validatedData['floor_id']);
    
            if ($floor) {
                // Update the floor details
                $floor->building_id = $validatedData['building_id'];
                $floor->floor_number = $validatedData['floor_number'];
                $floor->number_of_rooms = $validatedData['number_of_rooms'];
                $floor->save();
    
                return response()->json([
                    'message' => 'Floor updated successfully!',
                    'floor' => $floor
                ], 200);
            } else {
                return response()->json(['message' => 'Floor not found'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred', 'error' => $e->getMessage()], 500);
        }
    }
    


    public function deletefloor($id)
    {
        $floor = Floor::where('floor_id', $id)->first();

        if ($floor) {
            $deletedfloor = $floor;
            $floor->delete();

            return response()->json([
                'message' => 'floor has been deleted',
                'floor' => $deletedfloor
            ], 200);
        } else {
            return response()->json([
                'message' => 'Delete unsuccessful, no such floor exists'
            ], 404);
        }
    }
}


