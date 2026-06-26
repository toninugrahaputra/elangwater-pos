<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Assuming suppliers are Users with a specific role
use Illuminate\Http\JsonResponse;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        // Get users with supplier role
        $suppliers = User::whereHas('roles', function($query) {
            $query->where('name', 'supplier');
        })->get();

        return response()->json([
            'success' => true,
            'data' => $suppliers
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'contact_person' => 'required|string|max:255',
        ]);

        $user = User::create($validated);

        // Assign supplier role
        $user->assignRole('supplier');

        return response()->json([
            'success' => true,
            'data' => $user,
            'message' => 'Supplier created successfully'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $user = User::whereHas('roles', function($query) {
            $query->where('name', 'supplier');
        })->find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message': 'Supplier not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data': $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'contact_person' => 'required|string|max:255',
        ]);

        $user = User::whereHas('roles', function($query) {
            $query->where('name', 'supplier');
        })->find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message': 'Supplier not found'
            ], 404);
        }

        $user->update($validated);

        return response()->json([
            'success' => true,
            'data': $user,
            'message': 'Supplier updated successfully'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $deleted = User::whereHas('roles', function($query) {
            $query->where('name', 'supplier');
        })->destroy($id);

        if ($deleted === 0) {
            return response()->json([
                'success' => false,
                'message': 'Supplier not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message': 'Supplier deleted successfully'
        ]);
    }
}