<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Http\Resources\CustomerCollection;
use App\Http\Resources\CustomerResource;
use App\Services\CustomerService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CustomerController extends Controller
{
    protected $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    /**
     * Display a listing of the customers.
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->input('per_page', 15);
        $search = $request->input('search');

        $query = $this->customerService->getQuery();

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $customers = $query->paginate($perPage)
            ->appends(request()->query());

        return response()->json([
            'success' => true,
            'data' => new CustomerCollection($customers)
        ]);
    }

    /**
     * Store a newly created customer in storage.
     */
    public function store(StoreCustomerRequest $request): JsonResponse
    {
        $customer = $this->customerService->create($request->validated());

        return response()->json([
            'success' => true,
            'data' => new CustomerResource($customer),
            'message' => 'Customer created successfully'
        ], 201);
    }

    /**
     * Display the specified customer.
     */
    public function show(string $id): JsonResponse
    {
        $customer = $this->customerService->find($id);

        if (!$customer) {
            return response()->json([
                'success' => false,
                'message' => 'Customer not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => new CustomerResource($customer)
        ]);
    }

    /**
     * Update the specified customer in storage.
     */
    public function update(UpdateCustomerRequest $request, string $id): JsonResponse
    {
        $customer = $this->customerService->update($id, $request->validated());

        if (!$customer) {
            return response()->json([
                'success' => false,
                'message' => 'Customer not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => new CustomerResource($customer),
            'message' => 'Customer updated successfully'
        ]);
    }

    /**
     * Remove the specified customer from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $deleted = $this->customerService->delete($id);

        if (!$deleted) {
            return response()->json([
                'success' => false,
                'message' => 'Customer not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Customer deleted successfully'
        ]);
    }
}