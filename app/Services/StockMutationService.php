<?php

namespace App\Services;

use App\Repositories\StockMutationRepositoryInterface;

class StockMutationService
{
    protected $stockMutationRepository;

    public function __construct(StockMutationRepositoryInterface $stockMutationRepository)
    {
        $this->stockMutationRepository = $stockMutationRepository;
    }

    public function all()
    {
        return $this->stockMutationRepository->all();
    }

    public function find($id)
    {
        return $this->stockMutationRepository->find($id);
    }

    public function create(array $data)
    {
        return $this->stockMutationRepository->create($data);
    }

    public function update($id, array $data)
    {
        return $this->stockMutationRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->stockMutationRepository->delete($id);
    }
}