<?php

namespace App\Controller;

use App\Entity\Sale;


class SaleCountFavorites
{


    public function __invoke(Sale $data): int
    {
        return  $data->getFavorites()->count();
    }
}
