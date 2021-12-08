<?php


namespace App\Serializer;

use App\Entity\Auctioneer;
use App\Entity\Bid;
use App\Entity\File;
use App\Entity\Game;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\HttpFoundation\HttpFoundationExtension;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\Normalizer\ContextAwareDenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareTrait;


class AuctioneerOwnedDenormalizer implements ContextAwareDenormalizerInterface, DenormalizerAwareInterface
{
    use DenormalizerAwareTrait;

    private const ALREADY_CALLED_DENORMALIZER = 'AuctioneerOwnedDenormalizerCalled';


    public function __construct(private Security $security, private EntityManagerInterface $em, private TokenStorageInterface    $tokenInterface)
    {
    }
    public function  supportsDenormalization($data, string $type, ?string $format = null, array $context = [])
    {

        return (!isset($context[self::ALREADY_CALLED_DENORMALIZER]) && isset($context["resource_class"]) && $context["resource_class"] == Bid::class);
    }
    public function denormalize($data, string $type, ?string $format = null, array $context = [])
    {

        $roles = $this->tokenInterface->getToken()->getRoleNames();

        if ($this->security->getUser()) {
            if (in_array("ROLE_AUCTIONEER", $roles)) {
                $context[self::ALREADY_CALLED_DENORMALIZER] = true;
                $obj = $this->denormalizer->denormalize($data, $type, $format, $context);
                $obj->setAuctioneer($this->em->getRepository(Auctioneer::class)->find($this->security->getUser()->getId()));
                return $obj;
            } else {
                $context[self::ALREADY_CALLED_DENORMALIZER] = true;
                $obj = $this->denormalizer->denormalize($data, $type, $format, $context);
                return $obj;
            }
        } else {
            throw new BadRequestHttpException('you are not the owner of this game');
        }
    }
}
