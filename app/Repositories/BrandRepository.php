<?php

namespace App\Repositories;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Collection;

class BrandRepository implements BrandRepositoryInterface
{
    protected $model;

    public function __construct(Brand $brand)
    {
        $this->model = $brand;
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
        $brand = $this->model->find($id);
        if ($brand) {
            $brand->update($data);
            return $brand;
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