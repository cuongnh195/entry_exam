<?php

namespace App\Repositories\Hotel;

interface HotelRepositoryInterface
{
    public function all();
    public function find(int $id);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
    public function getHotelsByPrefectureId(int $prefectureId);
    public function search(string $name, array $columns);
    public function searchWithPrefecture(string $name);
}
