<?php

namespace App\Services;

use App\Models\Prefecture;
use App\Repositories\Prefecture\PrefectureRepositoryInterface;
use Illuminate\Support\Collection;

class PrefectureService
{
    private $prefectureRepository;

    public function __construct(
        PrefectureRepositoryInterface $prefectureRepository,
    ) {
        $this->prefectureRepository = $prefectureRepository;
    }

    /**
     * Get all prefectures
     *
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->prefectureRepository->all();
    }

    /**
     * Find prefecture by ID
     *
     * @param int $id
     * @return Prefecture
     */
    public function find(int $id): Prefecture   
    {
        return $this->prefectureRepository->find($id);
    }

    /**
     * Create prefecture
     *
     * @param array $data
     * @return Prefecture
     */
    public function create(array $data): Prefecture 
    {
        return $this->prefectureRepository->create($data);
    }

    /**
     * Update prefecture
     *
     * @param int $id
     * @param array $data
     * @return Prefecture
     */
    public function update(int $id, array $data): Prefecture
    {
        return $this->prefectureRepository->update($id, $data);
    }

    /**
     * Delete prefecture
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return $this->prefectureRepository->delete($id);
    }
}
