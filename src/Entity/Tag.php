<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use App\Repository\TagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=TagRepository::class)
 */
#[ApiResource(
    paginationItemsPerPage: 10,
    paginationMaximumItemsPerPage: 50,
    paginationClientItemsPerPage: true,
    itemOperations: [
        'get' => [
            'normalization_context' => ['groups' => ['read:Tag', 'read:Tags']]
        ],
        'patch' => [
            'path' => 'admin/tags/{id}',
            'normalization_context' => ['groups' => ['create:Tag']],
            'openapi_context' => [
                'tags' => ["Admin/Tag"],
            ]
        ],
        'delete' => [
            'path' => 'admin/tags/{id}',
            'openapi_context' => [
                'tags' => ["Admin/Tag"],
            ]
        ],
    ],
    collectionOperations: [
        'get' => [
            'normalization_context' => ['groups' => ['read:Tags']]
        ],
        'post' => [
            'path' => 'admin/tags',
            'normalization_context' => ['groups' => ['create:Tag']],
            'openapi_context' => [
                'tags' => ["Admin/Tag"],
            ]
        ],

    ],

)]

class Tag
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(['read:Sale', 'read:Tags'])]
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity=Sale::class, mappedBy="tags")
     */
    #[ApiSubresource(
        maxDepth: 1,
    )]
    private $sales;

    public function __construct()
    {
        $this->sales = new ArrayCollection();
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

    /**
     * @return Collection|Sale[]
     */
    public function getSales(): Collection
    {
        return $this->sales;
    }

    public function addSale(Sale $sale): self
    {
        if (!$this->sales->contains($sale)) {
            $this->sales[] = $sale;
            $sale->addTag($this);
        }

        return $this;
    }

    public function removeSale(Sale $sale): self
    {
        if ($this->sales->removeElement($sale)) {
            $sale->removeTag($this);
        }

        return $this;
    }
}
