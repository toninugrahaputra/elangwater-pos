<?php

namespace App\Repositories;

interface ProductRepositoryInterface
{
    public function all();

    public function find($id);

    public function create(array $data);

    public function update($id, array $data);

    public function delete($id);

    public function findBySku($sku);

    public function findByBarcode($barcode);

    public function getStock($productId, $warehouseId);
}