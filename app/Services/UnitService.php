<?php

namespace App\Services;

use App\Models\Unit;
use Illuminate\Database\Eloquent\Collection;

class UnitService
{
    /**
     * Get all units.
     */
    public function all(): Collection
    {
        return Unit::all();
    }

    /**
     * Create a new unit.
     */
    public function create(array $data): Unit
    {
        return Unit::create($data);
    }

    /**
     * Find a unit by ID.
     */
    public function find(string $id): ?Unit
    {
        return Unit::find($id);
    }

    /**
     * Update a unit.
     */
    public function update(string $id, array $data): ?Unit
    {
        $unit = $this->find($id);

        if (!$unit) {
            return null;
        }

        $unit->update($data);
        return $unit;
    }

    /**
     * Delete a unit.
     */
    public function delete(string $id): bool
    {
        $unit = $this->find($id);

        if (!$unit) {
            return false;
        }

        return $unit->delete() > 0;
    }
}