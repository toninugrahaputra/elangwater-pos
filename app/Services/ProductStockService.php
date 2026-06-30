<?php

namespace App\Services;

use App\Repositories\ProductStockRepositoryInterface;

class ProductStockService
{
    protected $productStockRepository;

    public function __construct(ProductStockRepositoryInterface $productStockRepository)
    {
        $this->productStockRepository = $productStockRepository;
    }

    public function all()
    {
        return $this->productStockRepository->all();
    }

    public function find($id)
    {
        return $this->productStockRepository->find($id);
    }

    public function create(array $data)
    {
        return $this->productStockRepository->create($data);
    }

    public function update($id, array $data)
    {
        return $this->productStockRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->productStockRepository->delete($id);
    }

    public function getStock($productId, $warehouseId)
    {
        return $this->productStockRepository->getStock($productId, $warehouseId);
    }

    public function updateStock($productId, $warehouseId, $quantity)
    {
        return $this->productStockRepository->updateStockByProductAndWarehouse($productId, $warehouseId, $quantity);
    }

    public function getQuery()
    {
        return $this->productStockRepository->getQuery();
    }
}