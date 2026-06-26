<?php

namespace App\Repositories;

use App\Models\ProductStock;
use Illuminate\Database\Eloquent\Collection;

class ProductStockRepository implements ProductStockRepositoryInterface
{
    protected $model;

    public function __construct(ProductStock $productStock)
    {
        $this->model = $productStock;
    }

    public function all()
    {
        return $this->model->with(['product', 'warehouse'])->get();
    }

    public function find($id)
    {
        return $this->model->with(['product', 'warehouse'])->find($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $stock = $this->model->find($id);
        if ($stock) {
            $stock->update($data);
            return $stock;
        }
        return null;
    }

    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    public function getStock($productId, $warehouseId)
    {
        $stock = $this->model->where('product_id', $productId)
            ->where('warehouse_id', $warehouseId)
            ->first();

        return $stock ? $stock->quantity : 0;
    }

    public function updateStockByProductAndWarehouse($productId, $warehouseId, $quantity)
    {
        $stock = $this->model->firstOrNew([
            'product_id' => $productId,
            'warehouse_id' => $warehouseId
        ]);
        $stock->quantity = $quantity;
        $stock->save();

        return $stock;
    }
}