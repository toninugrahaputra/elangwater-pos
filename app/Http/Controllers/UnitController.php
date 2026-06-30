<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUnitRequest;
use App\Http\Requests\UpdateUnitRequest;
use App\Http\Resources\UnitCollection;
use App\Http\Resources\UnitResource;
use App\Services\UnitService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    protected $unitService;

    public function __construct(UnitService $unitService)
    {
        $this->unitService = $unitService;
    }

    /**
     * Display a listing of the units.
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->query('per_page', 15);
        $search = $request->query('search');

        $query = $this->unitService->getQuery()
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                    ->orWhere('symbol', 'like', "%{$search}%");
            })
            ->orderBy('created_at', 'asc');

        $units = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => new UnitCollection($units),
            'meta' => [
                'current_page' => $units->currentPage(),
                'from' => $units->firstItem(),
                'last_page' => $units->lastPage(),
                'path' => $units->path(),
                'per_page' => $units->perPage(),
                'to' => $units->lastItem(),
                'total' => $units->total()
            ]
        ]);
    }

    /**
     * Store a newly created unit in storage.
     */
    public function store(StoreUnitRequest $request): JsonResponse
    {
        $unit = $this->unitService->create($request->validated());

        return response()->json([
            'success' => true,
            'data' => new UnitResource($unit),
            'message' => 'Unit created successfully'
        ], 201);
    }

    /**
     * Display the specified unit.
     */
    public function show(string $id): JsonResponse
    {
        $unit = $this->unitService->find($id);

        if (!$unit) {
            return response()->json([
                'success' => false,
                'message' => 'Unit not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => new UnitResource($unit)
        ]);
    }

    /**
     * Update the specified unit in storage.
     */
    public function update(UpdateUnitRequest $request, string $id): JsonResponse
    {
        $unit = $this->unitService->update($id, $request->validated());

        if (!$unit) {
            return response()->json([
                'success' => false,
                'message' => 'Unit not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => new UnitResource($unit),
            'message' => 'Unit updated successfully'
        ]);
    }

    /**
     * Remove the specified unit from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $deleted = $this->unitService->delete($id);

        if (!$deleted) {
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