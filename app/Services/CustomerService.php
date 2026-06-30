<?php

namespace App\Services;

use App\Repositories\CustomerRepositoryInterface;

class CustomerService
{
    protected $customerRepository;

    public function __construct(CustomerRepositoryInterface $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function all()
    {
        return $this->customerRepository->all();
    }

    public function find($id)
    {
        return $this->customerRepository->find($id);
    }

    public function create(array $data)
    {
        return $this->customerRepository->create($data);
    }

    public function update($id, array $data)
    {
        return $this->customerRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->customerRepository->delete($id);
    }

    public function getQuery()
    {
        return $this->customerRepository->getQuery();
    }
}