<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;
use App\Http\Resources\SupplierCollection;
use App\Http\Resources\SupplierResource;
use App\Services\SupplierService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class SupplierController extends Controller
{
    protected $supplierService;

    public function __construct(SupplierService $supplierService)
    {
        $this->supplierService = $supplierService;
    }

    /**
     * Display a listing of the suppliers.
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->input('per_page', 15);
        $search = $request->input('search');

        $query = $this->supplierService->getQuery();

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%")
                  ->orWhere('contact_person', 'like', "%{$search}%");
            });
        }

        $suppliers = $query->paginate($perPage)
            ->appends(request()->query());

        return response()->json([
            'success' => true,
            'data' => new SupplierCollection($suppliers)
        ]);
    }

    /**
     * Store a newly created supplier in storage.
     */
    public function store(StoreSupplierRequest $request): JsonResponse
    {
        $supplier = $this->supplierService->create($request->validated());

        return response()->json([
            'success' => true,
            'data' => new SupplierResource($supplier),
            'message' => 'Supplier created successfully'
        ], 201);
    }

    /**
     * Display the specified supplier.
     */
    public function show(string $id): JsonResponse
    {
        $supplier = $this->supplierService->find($id);

        if (!$supplier) {
            return response()->json([
                'success' => false,
                'message' => 'Supplier not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => new SupplierResource($supplier)
        ]);
    }

    /**
     * Update the specified supplier in storage.
     */
    public function update(UpdateSupplierRequest $request, string $id): JsonResponse
    {
        $supplier = $this->supplierService->update($id, $request->validated());

        if (!$supplier) {
            return response()->json([
                'success' => false,
                'message' => 'Supplier not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => new SupplierResource($supplier),
            'message' => 'Supplier updated successfully'
        ]);
    }

    /**
     * Remove the specified supplier from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $deleted = $this->supplierService->delete($id);

        if (!$deleted) {
            return response()->json([
                'success' => false,
                'message' => 'Supplier not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Supplier deleted successfully'
        ]);
    }
}