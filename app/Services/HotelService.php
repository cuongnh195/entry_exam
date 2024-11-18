<?php

namespace App\Services;

use App\Http\Requests\Admin\CreateHotelRequest;
use App\Models\Hotel;
use App\Repositories\Hotel\HotelRepositoryInterface;
use App\Models\Prefecture;

class HotelService
{
    protected $hotelRepository;
    protected $imageService;

    public function __construct(
        HotelRepositoryInterface $hotelRepository,
        ImageService $imageService
    ) {
        $this->hotelRepository = $hotelRepository;
        $this->imageService = $imageService;
    }

    /**
     * Get hotels by prefecture name
     *
     * @param string $prefectureNameAlpha
     * @return Collection
     */
    public function getHotelsByPrefectureName($prefectureNameAlpha)
    {
        $prefecture = Prefecture::where('prefecture_name_alpha', $prefectureNameAlpha)->first();
        return $this->hotelRepository->getHotelsByPrefectureId($prefecture->prefecture_id);
    }

    /**
     * Get hotel detail
     *
     * @param int $hotelId
     * @return Model
     */
    public function getHotelDetail(int $hotelId): Hotel
    {
        return $this->hotelRepository->find($hotelId);
    }

    /**
     * Create a new hotel
     *
     * @param array $data
     * @return Hotel
     */
    public function createHotel(array $data): Hotel
    {
        // save image to storage public/assets/img
        $imagePath = $this->imageService->saveImage($data['file']);
        $data['image_path'] = $imagePath;
        unset($data['file']);

        //TODO: add column file name to hotel table or create new table for image

        return $this->hotelRepository->create($data);
    }

    /**
     * Delete hotel
     *
     * @param int $hotelId
     * @return bool
     */
    public function deleteHotel($hotelId): bool
    {
        return $this->hotelRepository->delete($hotelId);
    }
    
    /**
     * Update hotel
     *
     * @param array $data
     * @param int $hotelId
     * @return Hotel
     */
    public function updateHotel(array $data, int $hotelId): Hotel
    {
        //check update image
        if (isset($data['file'])) {
            $imagePath = $this->imageService->saveImage($data['file']);
            $data['image_path'] = $imagePath;
            unset($data['file']);
        }

        //update hotel
        return $this->hotelRepository->update($hotelId, $data);
    }
}
