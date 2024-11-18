<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class BaseRepository
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Get all records
     *
     * @return Collection
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * Find a record by ID
     *
     * @param int $id
     * @return Model|null
     */
    public function find($id)
    {
        return $this->model->find($id);
    }

    /**
     * Create a new record
     *
     * @param array $data
     * @return Model
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * Update a record by ID
     *
     * @param int $id
     * @param array $data
     * @return Model|null
     */
    public function update($id, array $data)
    {
        $model = $this->find($id);
        if ($model) {
            $model->update($data);
            return $model;
        }
        return null;
    }

    /**
     * Delete a record by ID
     *
     * @param int $id
     * @return bool
     */
    public function delete($id)
    {
        $model = $this->find($id);
        if ($model) {
            return $model->delete();
        }
        return false;
    }

    /**
     * Paginate records
     *
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function paginate($perPage = 10) 
    {
        return $this->model->paginate($perPage);
    }
}
