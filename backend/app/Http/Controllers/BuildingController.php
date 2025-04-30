<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Building;

class BuildingController extends Controller
{
     /**
     * Display a list of all buildings
     */
    public function readBuildings(Request $request)
    {
        //display all buildings
        $building = Building::all();

        if ($building) {
            return response()->json($building);
        } else {
            return response("No building found");
        }
    }

    /**
     * create a new building
     */
    public function createBuilding(Request $request)
    {
        $validatedData=$request->validate([
            'building_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'number_of_floors' => 'required|integer',
        ]);

        try {
            $building = Building::create([
                'building_name' => $validatedData['building_name'],
                'location' => $validatedData['location'],
                'number_of_floors' => $validatedData['number_of_floors']
            ]);

            return response()->json([
                'message' => 'Building created successfully!',
                'building' => $building
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to create building!',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    //read a single building 
    public function readBuilding($building_id)
    {
        // Validate that the id is an integer
        if (!is_numeric($building_id) || intval($building_id) <= 0) {
            return response()->json(['error' => 'Invalid building ID'], 422);
        }

        // Find the building by ID
        $building = Building::find($building_id);

        // Check if the building exists
        if ($building) {
            // Return the building data as JSON
            return response()->json($building);
        } else {
            // Return an error response if the building does not exist
            return response()->json(['error' => 'building not found'], 404);
        }
    }

    public function updateBuilding(Request $request){
    $request->validate([
        'building_id' => 'required|exists:buildings,building_id',
        'building_name' => 'required|string|max:255',
        'location' => 'required|string|max:255',
        'number_of_floors' => 'required|integer'
    ]);

    try {
        $building = Building::find($request->building_id);

        if ($building) {
            // Update the building's details
            $building->building_name = $request->building_name;
            $building->location = $request->location;
            $building->number_of_floors = $request->number_of_floors;

            $building->save();

            return response()->json(['message' => 'building updated successfully', 'building' => $building], 200);
        } else {
            return response()->json(['message' => 'building not found'], 404);
        }
    } catch (\Exception $e) {
        return response()->json(['message' => 'An error occurred', 'error' => $e->getMessage()], 500);
    }
}


    public function deleteBuilding($id)
    {
        $building = Building::where('building_id', $id)->first();

        if ($building) {
            $deletedbuilding = $building;
            $building->delete();

            return response()->json([
                'message' => 'building has been deleted',
                'building' => $deletedbuilding
            ], 200);
        } else {
            return response()->json([
                'message' => 'Delete unsuccessful, no such building exists'
            ], 404);
        }
    }
}


