<?php

namespace App\Services;

use App\Repositories\SupplierRepositoryInterface;

class SupplierService
{
    protected $supplierRepository;

    public function __construct(SupplierRepositoryInterface $supplierRepository)
    {
        $this->supplierRepository = $supplierRepository;
    }

    public function all()
    {
        return $this->supplierRepository->all();
    }

    public function find($id)
    {
        return $this->supplierRepository->find($id);
    }

    public function create(array $data)
    {
        return $this->supplierRepository->create($data);
    }

    public function update($id, array $data)
    {
        return $this->supplierRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->supplierRepository->delete($id);
    }

    public function getQuery()
    {
        return $this->supplierRepository->getQuery();
    }
}