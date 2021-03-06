<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\CityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=CityRepository::class)
 */

#[ApiResource(
    paginationItemsPerPage: 10,
    paginationMaximumItemsPerPage: 50,
    paginationClientItemsPerPage: true,
    itemOperations: [
        'get' => [
            'normalization_context' => ['groups' => ['read:City', 'read:Cities']]
        ],
        'patch' => [
            'path' => 'admin/cities/{id}',
            'normalization_context' => ['groups' => ['create:City']],
            'openapi_context' => [
                'tags' => ["Admin/City"],
            ]
        ],
        'delete' => [
            'path' => 'admin/cities/{id}',
            'openapi_context' => [
                'tags' => ["Admin/City"],
            ]
        ],
    ],
    collectionOperations: [
        'get' => [
            'normalization_context' => ['groups' => ['read:Cities']]
        ],
        'post' => [
            'path' => 'admin/cities',
            'normalization_context' => ['groups' => ['create:City']],
            'openapi_context' => [
                'tags' => ["Admin/City"],
            ]
        ],

    ],

)]
#[ApiFilter(OrderFilter::class, properties: ['id' => 'ASC', 'name' => 'ASC', 'postalCode' => 'ASC'], arguments: ['orderParameterName' => 'order'])]
#[ApiFilter(SearchFilter::class, properties: ['id' => 'exact', 'name' => 'partial', 'postalCode' => 'exact'])]
class City
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    #[Groups(['read:Cities'])]
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(['read:Cities', 'create:City'])]
    private $name;

    /**
     * @ORM\Column(type="string", length=5)
     */
    #[Groups(['read:Cities', 'create:City'])]
    private $postalCode;

    /**
     * @ORM\ManyToOne(targetEntity=Department::class, inversedBy="cities")
     * @ORM\JoinColumn(nullable=false)
     */
    #[Groups(['read:City', 'create:City'])]
    private $Department;



    public function __construct()
    {
        $this->addresses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(string $postalCode): self
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getDepartment(): ?Department
    {
        return $this->Department;
    }

    public function setDepartment(?Department $Department): self
    {
        $this->Department = $Department;

        return $this;
    }
}
