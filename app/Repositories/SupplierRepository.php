<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class SupplierRepository implements SupplierRepositoryInterface
{
    protected $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function all(): Collection
    {
        return $this->model->whereHas('roles', function ($query) {
            $query->where('name', 'supplier');
        })->get();
    }

    public function find($id)
    {
        return $this->model->whereHas('roles', function ($query) {
            $query->where('name', 'supplier');
        })->find($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $user = $this->model->whereHas('roles', function ($query) {
            $query->where('name', 'supplier');
        })->find($id);

        if ($user) {
            $user->update($data);
            return $user;
        }

        return null;
    }

    public function delete($id)
    {
        return $this->model->whereHas('roles', function ($query) {
            $query->where('name', 'supplier');
        })->destroy($id);
    }

    public function getQuery(): Builder
    {
        return $this->model->newQuery()->whereHas('roles', function ($query) {
            $query->where('name', 'supplier');
        });
    }
}