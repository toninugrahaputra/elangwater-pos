<?php

namespace App\Repositories;

use App\Models\User; // Assuming customers are users with customer role

interface CustomerRepositoryInterface
{
    public function all();

    public function find($id);

    public function create(array $data);

    public function update($id, array $data);

    public function delete($id);

    public function getQuery();
}