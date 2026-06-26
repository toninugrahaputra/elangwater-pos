<?php

namespace App\Repositories;

use App\Models\ProductStock;

interface ProductStockRepositoryInterface
{
    public function all();

    public function find($id);

    public function create(array $data);

    public function update($id, array $data);

    public function delete($id);

    public function getStock($productId, $warehouseId);

    public function updateStockByProductAndWarehouse($productId, $warehouseId, $quantity);
}