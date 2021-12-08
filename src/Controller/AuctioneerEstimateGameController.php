<?php

namespace App\Controller;

use App\Entity\Auctioneer;
use App\Entity\Game;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;

class AuctioneerEstimateGameController
{
    public function __construct(private Security $security, private EntityManagerInterface $em)
    {
    }


    public function __invoke(Request $request)
    {


        $game =  $this->em->getRepository(Game::class)->find($request->get('id'));

        $idAuctioneer = $this->security->getUser()->getId();
        $auctioneer = $this->em->getRepository(Auctioneer::class)->find($idAuctioneer);


        $estimation = json_decode($request->getContent(), true)["estimation"];
        $game->setEstimation($estimation);


        return $game;
    }
}
