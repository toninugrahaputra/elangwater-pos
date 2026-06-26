<?php

namespace App\Services;

use App\Repositories\ProductRepositoryInterface;
use App\Services\ProductStockService;

class ProductService
{
    protected $productRepository;
    protected $productStockService;

    public function __construct(ProductRepositoryInterface $productRepository, ProductStockService $productStockService)
    {
        $this->productRepository = $productRepository;
        $this->productStockService = $productStockService;
    }

    public function all()
    {
        return $this->productRepository->all();
    }

    public function find($id)
    {
        return $this->productRepository->find($id);
    }

    public function create(array $data)
    {
        return $this->productRepository->create($data);
    }

    public function update($id, array $data)
    {
        return $this->productRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->productRepository->delete($id);
    }

    public function findBySku($sku)
    {
        return $this->productRepository->findBySku($sku);
    }

    public function findByBarcode($barcode)
    {
        return $this->productRepository->findByBarcode($barcode);
    }

    public function getProductStock($productId, $warehouseId)
    {
        return $this->productStockService->getStock($productId, $warehouseId);
    }

    public function updateStock($productId, $warehouseId, $quantity)
    {
        return $this->productStockService->updateStock($productId, $warehouseId, $quantity);
    }
}