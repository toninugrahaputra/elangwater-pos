<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Unit;
use Illuminate\Http\JsonResponse;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $units = Unit::all();
        return response()->json([
            'success' => true,
            'data' => $units
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50|unique:units,name',
            'symbol' => 'required|string|max:10|unique:units,symbol',
        ]);

        $unit = Unit::create($validated);

        return response()->json([
            'success' => true,
            'data' => $unit,
            'message' => 'Unit created successfully'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $unit = Unit::find($id);

        if (!$unit) {
            return response()->json([
                'success' => false,
                'message' => 'Unit not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $unit
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50|unique:units,name,' . $id,
            'symbol' => 'required|string|max:10|unique:units,symbol,' . $id,
        ]);

        $unit = Unit::find($id);
        if (!$unit) {
            return response()->json([
                'success' => false,
                'message' => 'Unit not found'
            ], 404);
        }

        $unit->update($validated);

        return response()->json([
            'success' => true,
            'data' => $unit,
            'message' => 'Unit updated successfully'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $deleted = Unit::destroy($id);

        if ($deleted === 0) {
            return response()->json([
                'success' => false,
                'message' => 'Unit not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Unit deleted successfully'
        ]);
    }
}