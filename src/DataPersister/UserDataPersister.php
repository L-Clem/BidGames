<?php

// src/DataPersister

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserDataPersister implements ContextAwareDataPersisterInterface
{

    /**
     * @var EntityManagerInterface
     */
    private $_entityManager;


    /**
     * @param Request
     */
    private $_request;

    public function __construct(
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher,
    ) {
        $this->_entityManager = $entityManager;
        $this->_passwordHasher = $passwordHasher;
    }
    public function supports($data, array $context = []): bool
    {
        return $data instanceof User;
    }

    public function persist($data, array $context = [])
    {
        if ($data->getPlainPassword()) {
            $data->setPassword(
                $this->_passwordHasher->hashPassword($data, $data->getPlainPassword())
            );

            $data->eraseCredentials();
        }
        $data->setRoles(["ROLE_USER"]);
        $this->_entityManager->persist($data);
        $this->_entityManager->flush();
    }

    public function remove($data, array $context = [])
    {
        $this->_entityManager->remove($data);
        $this->_entityManager->flush();
    }
}
