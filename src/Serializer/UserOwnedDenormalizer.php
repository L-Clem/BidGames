<?php


namespace App\Serializer;

use App\Entity\File;
use App\Entity\Game;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\HttpFoundation\HttpFoundationExtension;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\Normalizer\ContextAwareDenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareTrait;


class UserOwnedDenormalizer implements ContextAwareDenormalizerInterface, DenormalizerAwareInterface
{
    use DenormalizerAwareTrait;

    private const ALREADY_CALLED_DENORMALIZER = 'UserOwnedDenormalizerCalled';


    public function __construct(private Security $security, private EntityManagerInterface $em)
    {
    }
    public function  supportsDenormalization($data, string $type, ?string $format = null, array $context = [])
    {

        return !isset($context[self::ALREADY_CALLED_DENORMALIZER]) && isset($context["resource_class"]) && $context["resource_class"] ==  Game::class;
    }
    public function denormalize($data, string $type, ?string $format = null, array $context = [])
    {

        if ($this->security->getUser()) {
            if ($data->getOwner() == null) {
                $context[self::ALREADY_CALLED_DENORMALIZER] = true;
                $obj = $this->denormalizer->denormalize($data, $type, $format, $context);
                $obj->setOwner($this->em->getRepository(User::class)->find($this->security->getUser()->getId()));
                return $obj;
            } else {
                if ($data->getOwner() != $this->em->getRepository(User::class)->find($this->security->getUser()->getId())) {
                    throw new BadRequestHttpException('you are not the owner of this game');
                } else {
                    $context[self::ALREADY_CALLED_DENORMALIZER] = true;
                    $obj = $this->denormalizer->denormalize($data, $type, $format, $context);
                    $obj->setOwner($this->em->getRepository(User::class)->find($this->security->getUser()->getId()));
                    return $obj;
                }
            }
        } else {
            throw new BadRequestHttpException('you are not the owner of this game');
        }
    }
}
