<?php

namespace App\Repositories\Hotel;

use App\Models\Hotel;
use App\Repositories\BaseRepository;

class HotelRepository extends BaseRepository implements HotelRepositoryInterface
{
    public function __construct(Hotel $hotel)
    {
        parent::__construct($hotel);
    }

    /**
     * Get hotels by prefecture ID
     *
     * @param int $prefectureId
     * @return Collection
     */
    public function getHotelsByPrefectureId(int $prefectureId)
    {
        return $this->model
            ->where('prefecture_id', $prefectureId)
            ->inRandomOrder()
            ->get();
    }
}