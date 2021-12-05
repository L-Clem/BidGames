<?php

namespace App\Controller;

use App\Entity\Auctioneer;
use Symfony\Component\HttpFoundation\Request;


class AuctioneerAddGameController
{
    public function __invoke(Auctioneer $data, Request $request): Auctioneer
    {

        dd(json_decode($request->getContent(), true)["game"]);
    }
}
