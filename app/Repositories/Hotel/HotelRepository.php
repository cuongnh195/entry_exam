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

    /**
     * Search hotels by name
     *
     * @param string $name
     * @param array $columns
     * @return Collection
     */
    public function search(string $name, array $columns)
    {
        return $this->model->where(function ($query) use ($name, $columns) {
            foreach ($columns as $column) {
                $query->orWhere($column, 'like', '%' . $name . '%');
            }
        })->get();
        
    }

    /**
     * Search hotels by name with prefecture
     *
     * @param string $name
     * @return Collection
     */
    public function searchWithPrefecture(string $name)
    {
        return $this->model
            ->with('prefecture')
            ->where('hotel_name', 'like', '%' . $name . '%')
            ->orWhereHas('prefecture', function ($query) use ($name) {
                $query->where('prefecture_name', 'like', '%' . $name . '%');
            })
            ->get();
    }
}
