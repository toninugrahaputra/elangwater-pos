<?php

namespace App\Services;

use App\Repositories\WarehouseRepositoryInterface;

class WarehouseService
{
    protected $warehouseRepository;

    public function __construct(WarehouseRepositoryInterface $warehouseRepository)
    {
        $this->warehouseRepository = $warehouseRepository;
    }

    public function all()
    {
        return $this->warehouseRepository->all();
    }

    public function find($id)
    {
        return $this->warehouseRepository->find($id);
    }

    public function create(array $data)
    {
        return $this->warehouseRepository->create($data);
    }

    public function update($id, array $data)
    {
        return $this->warehouseRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->warehouseRepository->delete($id);
    }

    public function getQuery()
    {
        return $this->warehouseRepository->getQuery();
    }
}