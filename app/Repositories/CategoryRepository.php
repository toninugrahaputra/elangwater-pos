<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class CategoryRepository implements CategoryRepositoryInterface
{
    protected $model;

    public function __construct(Category $category)
    {
        $this->model = $category;
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
        $category = $this->model->find($id);
        if ($category) {
            $category->update($data);
            return $category;
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