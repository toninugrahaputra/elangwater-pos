<?php

namespace App\Services;

use App\Repositories\UnitRepositoryInterface;

class UnitService
{
    protected $unitRepository;

    public function __construct(UnitRepositoryInterface $unitRepository)
    {
        $this->unitRepository = $unitRepository;
    }

    public function all()
    {
        return $this->unitRepository->all();
    }

    public function find($id)
    {
        return $this->unitRepository->find($id);
    }

    public function create(array $data)
    {
        return $this->unitRepository->create($data);
    }

    public function update($id, array $data)
    {
        return $this->unitRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->unitRepository->delete($id);
    }

    public function getQuery()
    {
        return $this->unitRepository->getQuery();
    }
}