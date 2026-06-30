<?php

namespace App\Services;

use App\Repositories\PurchaseRepositoryInterface;

class PurchaseService
{
    protected $purchaseRepository;

    public function __construct(PurchaseRepositoryInterface $purchaseRepository)
    {
        $this->purchaseRepository = $purchaseRepository;
    }

    public function all()
    {
        return $this->purchaseRepository->all();
    }

    public function find($id)
    {
        return $this->purchaseRepository->find($id);
    }

    public function create(array $data)
    {
        return $this->purchaseRepository->create($data);
    }

    public function update($id, array $data)
    {
        return $this->purchaseRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->purchaseRepository->delete($id);
    }

    public function getQuery()
    {
        return $this->purchaseRepository->getQuery();
    }
}