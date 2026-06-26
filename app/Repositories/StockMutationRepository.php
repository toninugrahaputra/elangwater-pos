<?php

namespace App\Repositories;

use App\Models\StockMutation;
use Illuminate\Database\Eloquent\Collection;

class StockMutationRepository implements StockMutationRepositoryInterface
{
    protected $model;

    public function __construct(StockMutation $stockMutation)
    {
        $this->model = $stockMutation;
        // Eager load relationships for better performance
        $this->model->with(['product', 'warehouse']);
    }

    public function all()
    {
        return $this->model->with(['product', 'warehouse'])->get();
    }

    public function find($id)
    {
        return $this->model->with(['product', 'warehouse'])->find($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $stockMutation = $this->model->find($id);
        if ($stockMutation) {
            $stockMutation->update($data);
            return $stockMutation;
        }
        return null;
    }

    public function delete($id)
    {
        return $this->model->destroy($id);
    }
}