<?php

namespace App\Controller;

use App\Entity\Auctioneer;
use App\Entity\DepositAddress;
use App\Entity\Game;
use App\Entity\PurchaseOrder;
use App\Entity\User;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Security\Core\Security;

class UserMakePurchaseOrder
{
    public function __construct(private Security $security, private EntityManagerInterface $em)
    {
    }


    public function __invoke(Request $request)
    {
        $salebid =  $this->em->getRepository(salesBid::class)->find($request->get('SalesBidId'));
        $user =  $this->em->getRepository(User::class)->find($this->security->getUser()->getId());
        $amount = $depositAdressId = json_decode($request->getContent(), true)["amount"];
        $purchaseOrder = new PurchaseOrder();
        $purchaseOrder->setAmount($amount);
        $purchaseOrder->setEmissionTime(new \DateTime());
        $purchaseOrder->setUser($user);
        $salebid->addPurchaseOrder($purchaseOrder);
        $this->em->persist($salebid);

        $this->em->flush();
        return $salebid;
    }
}
