<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
#[ApiResource(
    paginationItemsPerPage: 10,
    paginationMaximumItemsPerPage: 50,
    paginationClientItemsPerPage: true,
    itemOperations: [
        'get' => [
            'normalization_context' => ['groups' => ['read:Category', 'read:Categories']]
        ],
        'patch' => [
            'path' => 'admin/categories/{id}',
            'normalization_context' => ['groups' => ['create:Category']],
            'openapi_context' => [
                'tags' => ["Admin/Category"],
            ]
        ],
        'delete' => [
            'path' => 'admin/categories/{id}',
            'openapi_context' => [
                'tags' => ["Admin/Category"],
            ]
        ],
    ],
    collectionOperations: [
        'get' => [
            'normalization_context' => ['groups' => ['read:Categories']]
        ],
        'post' => [
            'path' => 'admin/categories',
            'normalization_context' => ['groups' => ['create:Category']],
            'openapi_context' => [
                'tags' => ["Admin/Category"],
            ]
        ],

    ],

)]
class Category
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    #[Groups(['read:Category'])]
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(['read:Sale', 'read:Games', 'read:Categories', 'read:Sale', 'create:Categories'])]
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity=Game::class, inversedBy="categories")
     * @ORM\JoinColumn(nullable=false)
     */
    #[ApiSubresource(
        maxDepth: 1,
    )]
    private $game;

    public function __construct()
    {
        $this->game = new ArrayCollection();
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
     * @return Collection|Game[]
     */
    public function getGame(): Collection
    {
        return $this->game;
    }

    public function addGame(Game $game): self
    {
        if (!$this->game->contains($game)) {
            $this->game[] = $game;
        }

        return $this;
    }

    public function removeGame(Game $game): self
    {
        $this->game->removeElement($game);

        return $this;
    }
}
