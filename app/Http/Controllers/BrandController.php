<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\BrandService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\JsonResponse;

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
    public function index(): JsonResponse
    {
        $brands = $this->brandService->all();
        return response()->json([
            'success' => true,
            'data' => $brands
        ]);
    }

    /**
     * Store a newly created brand in storage.
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $this->validateBrand($request);

            $brand = $this->brandService->create($request->all());

            return response()->json([
                'success' => true,
                'data' => $brand,
                'message' => 'Brand created successfully'
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create brand',
                'error' => $e->getMessage()
            ], 500);
        }
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
            'data' => $brand
        ]);
    }

    /**
     * Update the specified brand in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        try {
            $this->validateBrand($request, $id);

            $brand = $this->brandService->update($id, $request->all());

            if (!$brand) {
                return response()->json([
                    'success' => false,
                    'message' => 'Brand not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $brand,
                'message' => 'Brand updated successfully'
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update brand',
                'error' => $e->getMessage()
            ], 500);
        }
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

    /**
     * Validate brand data.
     */
    protected function validateBrand(Request $request, $id = null)
    {
        $rules = [
            'name' => 'required|string|max:255|unique:brands,name,' . ($id ?? ''),
            'description' => 'nullable|string',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
}