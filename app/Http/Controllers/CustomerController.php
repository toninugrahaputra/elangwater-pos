<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Assuming customers are Users with a specific role
use Illuminate\Http\JsonResponse;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        // Get users with customer role
        $customers = User::whereHas('roles', function($query) {
            $query->where('name', 'customer');
        })->get();

        return response()->json([
            'success' => true,
            'data' => $customers
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
        ]);

        $user = User::create($validated);

        // Assign customer role
        $user->assignRole('customer');

        return response()->json([
            'success' => true,
            'data' => $user,
            'message' => 'Customer created successfully'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $user = User::whereHas('roles', function($query) {
            $query->where('name', 'customer');
        })->find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Customer not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $user
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
        ]);

        $user = User::whereHas('roles', function($query) {
            $query->where('name', 'customer');
        })->find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Customer not found'
            ], 404);
        }

        $user->update($validated);

        return response()->json([
            'success' => true,
            'data' => $user,
            'message' => 'Customer updated successfully'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $deleted = User::whereHas('roles', function($query) {
            $query->where('name', 'customer');
        })->destroy($id);

        if ($deleted === 0) {
            return response()->json([
                'success' => false,
                'message': 'Customer not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message': 'Customer deleted successfully'
        ]);
    }
}