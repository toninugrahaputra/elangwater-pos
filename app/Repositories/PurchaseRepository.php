<?php

namespace App\Repositories;

use App\Models\Purchase;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class PurchaseRepository implements PurchaseRepositoryInterface
{
    protected $model;

    public function __construct(Purchase $purchase)
    {
        $this->model = $purchase;
    }

    public function all(): Collection
    {
        return $this->model->with(['supplier', 'items.product'])->get();
    }

    public function find($id)
    {
        return $this->model->with(['supplier', 'items.product'])->find($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $purchase = $this->model->find($id);
        if ($purchase) {
            $purchase->update($data);
            return $purchase;
        }
        return null;
    }

    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    public function getQuery(): Builder
    {
        return $this->model->newQuery();
    }
}