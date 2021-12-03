<?php

namespace App\DataProvider;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryResultCollectionExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGenerator;
use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use App\Entity\Auctioneer;
use App\Repository\AuctioneerRepository;
use Doctrine\Persistence\ManagerRegistry;

class AuctioneerDataProvider implements ContextAwareCollectionDataProviderInterface
{

    private $collectionExtensions;
    private $managerRegistry;
    private $excludedResources;

    public function __construct(ManagerRegistry $managerRegistry, /* iterable */ $collectionExtensions = [])
    {
        $this->collectionExtensions = $collectionExtensions;
        $this->managerRegistry = $managerRegistry;
    }
    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return Auctioneer::class === $resourceClass;
    }

    public function getCollection(string $resourceClass, string $operationName = null, array $context = [])
    {
        $manager = $this->managerRegistry->getManagerForClass($resourceClass);
        $repository = $manager->getRepository($resourceClass);
        $queryBuilder = $repository->createQueryBuilder('a')
            ->andWhere('a.desactivated = :val')
            ->setParameter('val', false);
        $queryNameGenerator = new QueryNameGenerator();

        foreach ($this->collectionExtensions as $extension) {

            $extension->applyToCollection($queryBuilder, $queryNameGenerator, $resourceClass, $operationName, $context);

            if ($extension instanceof QueryResultCollectionExtensionInterface && $extension->supportsResult($resourceClass, $operationName, $context)) {
                return $extension->getResult($queryBuilder, $resourceClass, $operationName, $context);
            }
        }

        return $queryBuilder->getQuery()->getResult();
    }
}
