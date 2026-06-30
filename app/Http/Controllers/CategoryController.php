<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;
use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Display a listing of the categories.
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->query('per_page', 15);
        $search = $request->query('search');

        $query = $this->categoryService->getQuery()
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%");
            })
            ->orderBy('created_at', 'desc');

        $categories = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => new CategoryCollection($categories),
            'meta' => [
                'current_page' => $categories->currentPage(),
                'from' => $categories->firstItem(),
                'last_page' => $categories->lastPage(),
                'path' => $categories->path(),
                'per_page' => $categories->perPage(),
                'to' => $categories->lastItem(),
                'total' => $categories->total()
            ]
        ]);
    }

    /**
     * Store a newly created category in storage.
     */
    public function store(StoreCategoryRequest $request): JsonResponse
    {
        $category = $this->categoryService->create($request->validated());

        return response()->json([
            'success' => true,
            'data' => new CategoryResource($category),
            'message' => 'Category created successfully'
        ], 201);
    }

    /**
     * Display the specified category.
     */
    public function show(string $id): JsonResponse
    {
        $category = $this->categoryService->find($id);

        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Category not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => new CategoryResource($category)
        ]);
    }

    /**
     * Update the specified category in storage.
     */
    public function update(UpdateCategoryRequest $request, string $id): JsonResponse
    {
        $category = $this->categoryService->update($id, $request->validated());

        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Category not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => new CategoryResource($category),
            'message' => 'Category updated successfully'
        ]);
    }

    /**
     * Remove the specified category from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $deleted = $this->categoryService->delete($id);

        if (!$deleted) {
            return response()->json([
                'success' => false,
                'message' => 'Category not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Category deleted successfully'
        ]);
    }
}