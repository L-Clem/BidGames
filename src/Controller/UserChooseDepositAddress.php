<?php

namespace App\Controller;

use App\Entity\Auctioneer;
use App\Entity\DepositAddress;
use App\Entity\Game;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Security\Core\Security;

class UserChooseDepositAddress
{
    public function __construct(private Security $security, private EntityManagerInterface $em)
    {
    }


    public function __invoke(Request $request)
    {
        $game =  $this->em->getRepository(Game::class)->find($request->get('gameId'));


        if ($this->security->getUser()->getId() != $game->getOwner()->getId()) {
            throw new BadRequestHttpException('you are not the owner of this game');
        } else {
            $depositAdressId = json_decode($request->getContent(), true)["DepositAdress"];
            $depositAdress = $this->em->getRepository(DepositAddress::class)->find($depositAdressId);
            $game->setDepositAddress($depositAdress);
        }



        return $game;
    }
}
