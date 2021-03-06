<?php

namespace App\Controller;

use App\Entity\Auctioneer;
use App\Entity\Game;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;

class AuctioneerAddGameController
{
    public function __construct(private Security $security, private EntityManagerInterface $em)
    {
    }


    public function __invoke(Request $request)
    {
        $idAuctioneer = $this->security->getUser()->getId();
        $auctioneer = $this->em->getRepository(Auctioneer::class)->find($idAuctioneer);

        $GameArray = json_decode($request->getContent(), true)["Game"];
        foreach ($GameArray as $id) {
            $game =  $this->em->getRepository(Game::class)->find($id);
            $game->setAuctioneer($auctioneer);
        }

        return $auctioneer;
    }
}
