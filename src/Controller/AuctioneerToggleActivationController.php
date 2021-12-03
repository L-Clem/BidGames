<?php

namespace App\Controller;

use App\Entity\Auctioneer;

class AuctioneerToggleActivationController
{
    public function __invoke(Auctioneer $data): Auctioneer
    {
        $toggle = $data->getDesactivated();
        $toggle = !$toggle;
        $data->setDesactivated($toggle);
        return $data;
    }
}
