<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePurchaseRequest;
use App\Http\Requests\UpdatePurchaseRequest;
use App\Http\Resources\PurchaseCollection;
use App\Http\Resources\PurchaseResource;
use App\Services\PurchaseService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PurchaseController extends Controller
{
    protected $purchaseService;

    public function __construct(PurchaseService $purchaseService)
    {
        $this->purchaseService = $purchaseService;
    }

    /**
     * Display a listing of the purchases.
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->input('per_page', 15);
        $search = $request->input('search');

        $query = $this->purchaseService->getQuery();

        if ($search) {
            $query->whereHas('supplier', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            })->orWhereHas('items.product', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%")
                  ->orWhere('barcode', 'like', "%{$search}%");
            });
        }

        $purchases = $query->with(['supplier', 'items.product'])
            ->paginate($perPage)
            ->appends(request()->query());

        return response()->json([
            'success' => true,
            'data' => new PurchaseCollection($purchases)
        ]);
    }

    /**
     * Store a newly created purchase in storage.
     */
    public function store(StorePurchaseRequest $request): JsonResponse
    {
        $purchase = $this->purchaseService->create($request->validated());

        return response()->json([
            'success' => true,
            'data' => new PurchaseResource($purchase->load(['supplier', 'items.product'])),
            'message' => 'Purchase created successfully'
        ], 201);
    }

    /**
     * Display the specified purchase.
     */
    public function show(string $id): JsonResponse
    {
        $purchase = $this->purchaseService->find($id);

        if (!$purchase) {
            return response()->json([
                'success' => false,
                'message' => 'Purchase not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => new PurchaseResource($purchase->load(['supplier', 'items.product']))
        ]);
    }

    /**
     * Update the specified purchase in storage.
     */
    public function update(UpdatePurchaseRequest $request, string $id): JsonResponse
    {
        $purchase = $this->purchaseService->update($id, $request->validated());

        if (!$purchase) {
            return response()->json([
                'success' => false,
                'message' => 'Purchase not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => new PurchaseResource($purchase->load(['supplier', 'items.product'])),
            'message' => 'Purchase updated successfully'
        ]);
    }

    /**
     * Remove the specified purchase from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $deleted = $this->purchaseService->delete($id);

        if (!$deleted) {
            return response()->json([
                'success' => false,
                'message' => 'Purchase not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Purchase deleted successfully'
        ]);
    }
}