<?php

namespace App\Controller;

use App\Entity\Announce;


class AnnounceCountFavorites
{


    public function __invoke(Announce $data): int
    {
        return $data->getFavorites()->count();
    }
}
