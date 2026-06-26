<?php

namespace App\Repositories;

use App\Models\Warehouse;
use Illuminate\Database\Eloquent\Collection;

class WarehouseRepository implements WarehouseRepositoryInterface
{
    protected $model;

    public function __construct(Warehouse $warehouse)
    {
        $this->model = $warehouse;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $warehouse = $this->model->find($id);
        if ($warehouse) {
            $warehouse->update($data);
            return $warehouse;
        }
        return null;
    }

    public function delete($id)
    {
        return $this->model->destroy($id);
    }
}