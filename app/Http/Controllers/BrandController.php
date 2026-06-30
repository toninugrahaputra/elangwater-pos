<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;
use App\Http\Resources\BrandCollection;
use App\Http\Resources\BrandResource;
use App\Services\BrandService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    protected $brandService;

    public function __construct(BrandService $brandService)
    {
        $this->brandService = $brandService;
    }

    /**
     * Display a listing of the brands.
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->query('per_page', 15);
        $search = $request->query('search');

        $query = $this->brandService->getQuery()
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            })
            ->orderBy('created_at', 'desc');

        $brands = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => new BrandCollection($brands),
            'meta' => [
                'current_page' => $brands->currentPage(),
                'from' => $brands->firstItem(),
                'last_page' => $brands->lastPage(),
                'path' => $brands->path(),
                'per_page' => $brands->perPage(),
                'to' => $brands->lastItem(),
                'total' => $brands->total()
            ]
        ]);
    }

    /**
     * Store a newly created brand in storage.
     */
    public function store(StoreBrandRequest $request): JsonResponse
    {
        $brand = $this->brandService->create($request->validated());

        return response()->json([
            'success' => true,
            'data' => new BrandResource($brand),
            'message' => 'Brand created successfully'
        ], 201);
    }

    /**
     * Display the specified brand.
     */
    public function show(string $id): JsonResponse
    {
        $brand = $this->brandService->find($id);

        if (!$brand) {
            return response()->json([
                'success' => false,
                'message' => 'Brand not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => new BrandResource($brand)
        ]);
    }

    /**
     * Update the specified brand in storage.
     */
    public function update(UpdateBrandRequest $request, string $id): JsonResponse
    {
        $brand = $this->brandService->update($id, $request->validated());

        if (!$brand) {
            return response()->json([
                'success' => false,
                'message' => 'Brand not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => new BrandResource($brand),
            'message' => 'Brand updated successfully'
        ]);
    }

    /**
     * Remove the specified brand from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $deleted = $this->brandService->delete($id);

        if (!$deleted) {
            return response()->json([
                'success' => false,
                'message' => 'Brand not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Brand deleted successfully'
        ]);
    }
}