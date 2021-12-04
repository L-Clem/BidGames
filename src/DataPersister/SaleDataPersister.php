<?php

// src/DataPersister

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\Sale;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class SaleDataPersister implements ContextAwareDataPersisterInterface
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
        RequestStack $request
    ) {
        $this->_entityManager = $entityManager;
        $this->_request = $request->getCurrentRequest();
    }
    public function supports($data, array $context = []): bool
    {
        return $data instanceof Sale;
    }

    public function persist($data, array $context = [])
    {
        if ($this->_request->getMethod() == 'POST') {
            $data->setPublishedAt(new \DateTime());
        }
        $this->_entityManager->persist($data);
        $this->_entityManager->flush();
    }
    public function remove($data, array $context = [])
    {
        $this->_entityManager->remove($data);
        $this->_entityManager->flush();
    }
}
