<?php

namespace App\Services;

use App\Repositories\BrandRepositoryInterface;

class BrandService
{
    protected $brandRepository;

    public function __construct(BrandRepositoryInterface $brandRepository)
    {
        $this->brandRepository = $brandRepository;
    }

    public function all()
    {
        return $this->brandRepository->all();
    }

    public function find($id)
    {
        return $this->brandRepository->find($id);
    }

    public function create(array $data)
    {
        return $this->brandRepository->create($data);
    }

    public function update($id, array $data)
    {
        return $this->brandRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->brandRepository->delete($id);
    }
}