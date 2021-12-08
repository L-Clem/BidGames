<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Controller\SaleCountFavorites;
use App\Repository\SaleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=SaleRepository::class)
 */
#[ApiResource(
    paginationItemsPerPage: 10,
    paginationMaximumItemsPerPage: 50,
    paginationClientItemsPerPage: true,
    itemOperations: [
        'get' => [
            'normalization_context' => ['groups' => ['read:Sale', 'read:Sales']]
        ],
        'patch' => [
            'denormalization_context' => ['groups' => ['update:Sale', 'create:Sale']],
            "security" => "is_granted('ROLE_AUCTIONEER') or is_granted('ROLE_USER')",
        ],
        'delete',
        'countFavorites' => [
            'method' => 'GET',
            'path' => '/sales/{id}/favorites/count',
            'controller' => SaleCountFavorites::class,
            'openapi_context' => [
                'summary' => 'Give you the favorites users number who favorite your sale ',
                'responses' => [
                    '200' => [
                        'description' => 'OK',
                        'content' => [
                            'application/json' => [
                                'schema' => [
                                    'type' => 'integer',
                                    'example' => 5
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ],
    collectionOperations: [
        'get' => [
            'normalization_context' => ['groups' => ['read:Sales']]
        ],
        'post' => [
            'denormalization_context' => ['groups' => ['create:Sale']],
            "security" => "is_granted('ROLE_AUCTIONEER') or is_granted('ROLE_USER')",
        ],
        'addImage' => [
            'method' => 'POST',
            'controller' => PostImageController::class,

            'path' => '/games/{id}/image',
            'deserialize' => false,
            'openapi_context' => [
                'requestBody' => [
                    'content' => [
                        'multipart/form-data' => [
                            'schema' => [
                                'type' => 'object',
                                'properties' => [
                                    'file' => [
                                        'type' => 'string',
                                        'format' => 'binary',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],

        ],
    ],
)]
#[ApiFilter(
    SearchFilter::class,
    properties: ['title' => 'partial', 'game.title' => 'partial', 'tag.name' => 'partial'],
)]

#[ApiFilter(
    DateFilter::class,
    properties: ['publishedAt']
)]

class Sale
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    #[Groups(['read:Sales', 'read:Bid'])]
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(['read:Sales', 'create:Sale', 'read:Bid'])]
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(['read:Sale', 'create:Sale', 'read:Bid'])]
    private $description;

    /**
     * @ORM\Column(type="integer")
     */
    #[Groups(['read:Sale'])]
    private $lotNumber;

    /**
     * @ORM\Column(type="datetime")
     */
    #[Groups(['read:Sale'])]
    private $publishedAt;

    /**
     * @ORM\Column(type="integer")
     */
    #[Groups(['read:Sale'])]
    private $tax;

    /**
     * @ORM\ManyToMany(targetEntity=Game::class, inversedBy="sales")
     */
    #[Groups(['read:Sale', 'create:Sale'])]
    private $game;

    /**
     * @ORM\ManyToMany(targetEntity=User::class)
     */
    private $favorites;

    /**
     * @ORM\OneToOne(targetEntity=File::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    #[Groups(['read:Sale', 'read:Bid'])]
    private $picture;

    /**
     * @ORM\ManyToMany(targetEntity=Tag::class, inversedBy="sales")
     */
    #[Groups(['read:Sale', 'read:Bid'])]
    private $tags;

    /**
     * @ORM\OneToMany(targetEntity=SaleBid::class, mappedBy="sale", orphanRemoval=true)
     * @ORM\JoinColumn(nullable=true)
     */
    #[Groups(['update:Auctionner', 'read:Sale'])]
    private $saleBids;

    public function __construct()
    {
        $this->game = new ArrayCollection();
        $this->favorites = new ArrayCollection();
        $this->tags = new ArrayCollection();
        $this->saleBids = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getLotNumber(): ?int
    {
        return $this->lotNumber;
    }

    public function setLotNumber(int $lotNumber): self
    {
        $this->lotNumber = $lotNumber;

        return $this;
    }

    public function getPublishedAt(): ?\DateTimeInterface
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(\DateTimeInterface $publishedAt): self
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }

    public function getTax(): ?int
    {
        return $this->tax;
    }

    public function setTax(int $tax): self
    {
        $this->tax = $tax;

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

    /**
     * @return Collection|User[]
     */
    public function getFavorites(): Collection
    {
        return $this->favorites;
    }

    public function addFavorite(User $favorite): self
    {
        if (!$this->favorites->contains($favorite)) {
            $this->favorites[] = $favorite;
        }

        return $this;
    }

    public function removeFavorite(User $favorite): self
    {
        $this->favorites->removeElement($favorite);

        return $this;
    }

    public function getPicture(): ?File
    {
        return $this->picture;
    }

    public function setPicture(File $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * @return Collection|Tag[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        $this->tags->removeElement($tag);

        return $this;
    }

    /**
     * @return Collection|SaleBid[]
     */
    public function getSaleBids(): Collection
    {
        return $this->saleBids;
    }

    public function addSaleBid(SaleBid $saleBid): self
    {
        if (!$this->saleBids->contains($saleBid)) {
            $this->saleBids[] = $saleBid;
            $saleBid->setSale($this);
        }

        return $this;
    }

    public function removeSaleBid(SaleBid $saleBid): self
    {
        if ($this->saleBids->removeElement($saleBid)) {
            // set the owning side to null (unless already changed)
            if ($saleBid->getSale() === $this) {
                $saleBid->setSale(null);
            }
        }

        return $this;
    }
}
