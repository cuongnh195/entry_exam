<?php

namespace App\Repositories\Prefecture;

use App\Models\Prefecture;
use App\Repositories\BaseRepository;

class PrefectureRepository extends BaseRepository implements PrefectureRepositoryInterface
{
    public function __construct(Prefecture $prefecture)
    {
        parent::__construct($prefecture);
    }
}
    