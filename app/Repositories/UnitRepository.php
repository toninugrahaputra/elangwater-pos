<?php

namespace App\Repositories;

use App\Models\Unit;
use Illuminate\Database\Eloquent\Collection;

class UnitRepository implements UnitRepositoryInterface
{
    protected $model;

    public function __construct(Unit $unit)
    {
        $this->model = $unit;
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
        $unit = $this->model->find($id);
        if ($unit) {
            $unit->update($data);
            return $unit;
        }
        return null;
    }

    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    public function getQuery()
    {
        return $this->model->newQuery();
    }
}
