<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;

interface SupplierRepositoryInterface
{
    public function all();

    public function find($id);

    public function create(array $data);

    public function update($id, array $data);

    public function delete($id);

    public function getQuery(): Builder;
}