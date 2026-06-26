<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\ProductStock;
use Illuminate\Database\Eloquent\Collection;

class ProductRepository implements ProductRepositoryInterface
{
    protected $model;

    public function __construct(Product $product)
    {
        $this->model = $product;
    }

    public function all()
    {
        return $this->model->with(['category', 'brand'])->get();
    }

    public function find($id)
    {
        return $this->model->with(['category', 'brand'])->find($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $product = $this->model->find($id);
        if ($product) {
            $product->update($data);
            return $product;
        }
        return null;
    }

    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    public function findBySku($sku)
    {
        return $this->model->where('sku', $sku)->first();
    }

    public function findByBarcode($barcode)
    {
        return $this->model->where('barcode', $barcode)->first();
    }

    public function getStock($productId, $warehouseId)
    {
        $stock = ProductStock::where('product_id', $productId)
            ->where('warehouse_id', $warehouseId)
            ->first();

        return $stock ? $stock->quantity : 0;
    }
}