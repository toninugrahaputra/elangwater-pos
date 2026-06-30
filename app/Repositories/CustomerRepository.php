<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class CustomerRepository implements CustomerRepositoryInterface
{
    protected $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function all(): Collection
    {
        return $this->model->whereHas('roles', function ($query) {
            $query->where('name', 'customer');
        })->get();
    }

    public function find($id)
    {
        return $this->model->whereHas('roles', function ($query) {
            $query->where('name', 'customer');
        })->find($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $user = $this->model->whereHas('roles', function ($query) {
            $query->where('name', 'customer');
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
            $query->where('name', 'customer');
        })->destroy($id);
    }

    public function getQuery(): Builder
    {
        return $this->model->newQuery()->whereHas('roles', function ($query) {
            $query->where('name', 'customer');
        });
    }
}