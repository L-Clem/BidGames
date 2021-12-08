<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use App\Controller\AuctioneerAddGameController;
use App\Controller\AuctioneerEstimateGameController;
use App\Controller\AuctioneerToggleActivationController;
use App\Controller\IndividualToggleActivationController;
use App\Repository\AuctioneerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * *
 * @ORM\Entity(repositoryClass=AuctioneerRepository::class)
 */
#[ApiResource(
    paginationItemsPerPage: 10,
    paginationMaximumItemsPerPage: 50,
    paginationClientItemsPerPage: true,
    itemOperations: [
        'get' => [
            'normalization_context' => ['groups' => ['read:Auctionner', 'read:Auctionners']]
        ],
        'patch' => [
            'denormalization_context' => ['groups' => ['update:Auctionner', 'create:Auctionner']],
            "security" => "is_granted('ROLE_AUCTIONEER')",
            'openapi_context' => [
                'summary' => 'Update an auctioneer ressource , can only be use by an auctioneer',
            ]
        ],
        'delete' => [
            'path' => 'admin/auctioneers/{id}',
            'openapi_context' => [
                'tags' => ["Admin/Auctioneer"],
            ]
        ],
        'addGame' => [
            'method' => 'POST',
            'path' => '/auctioneers/addgames',
            'controller' => AuctioneerAddGameController::class,
            "security" => "is_granted('ROLE_AUCTIONEER')",
            "read" => false,
            'openapi_context' => [
                'summary' => 'allow to add  a game for an auctioneer (use the current auctioneer)',
                'requestBody' => [
                    'content' => [
                        'application/json' => [
                            'schema' => [
                                'type' => "object",
                                "properties" => [
                                    "Games" => [
                                        "type" => "array",
                                        "items" => [
                                            "type" => "string"
                                        ]

                                    ]
                                ]
                            ],
                        ]
                    ]
                ]
            ]
        ],
        'estimateGame' => [
            'method' => 'POST',
            'path' => '/auctioneers/estimate/{id}',
            'controller' => AuctioneerEstimateGameController::class,
            "security" => "is_granted('ROLE_AUCTIONEER')",
            "read" => false,
            'openapi_context' => [
                'summary' => 'allow to estimate a game , only work if the auctioneer own the game(use the current auctioneer)',
                'requestBody' => [
                    'content' => [
                        'application/json' => [
                            'schema' => [
                                'type' => "object",
                                "properties" => [
                                    "estimation" => [
                                        "type" => "number",
                                    ]
                                ]
                            ],
                        ]
                    ]
                ]
            ]
        ],
    ],
    collectionOperations: [
        'get' => [
            'normalization_context' => ['groups' => ['read:Auctionners']]
        ],
        'post' => [
            'path' => 'admin/auctioneers',
            'denormalization_context' => ['groups' => ['create:Auctionner']],
            'openapi_context' => [
                'tags' => ["Admin/Auctioneer"],

            ]
        ],

    ],

)]
#[ApiFilter(OrderFilter::class, properties: ['firstname' => 'ASC', 'lastname' => 'ASC'], arguments: ['orderParameterName' => 'order'])]
#[ApiFilter(SearchFilter::class, properties: ['id' => 'exact', 'voluntary' => 'exact', 'auctionHouse.name' => 'partial'])]
class Auctioneer extends Individual
{

    /**
     * @ORM\Column(type="boolean")
     * 
     */
    #[Groups(['read:Auctionners', 'create:Auctionner'])]
    private $voluntary;

    /**
     * @ORM\OneToMany(targetEntity=Bid::class, mappedBy="auctioneer")
     */
    #[Groups(['update:Auctionner'])]
    #[ApiSubresource(
        maxDepth: 1,
    )]
    private $bids;

    /**
     * @ORM\ManyToOne(targetEntity=AuctionHouse::class, inversedBy="auctioneers")
     * @ORM\JoinColumn(nullable=false)
     */
    #[Groups(['read:Auctionner', 'create:Auctionner', 'read:Bid'])]
    private $auctionHouse;

    /**
     * @ORM\OneToMany(targetEntity=Game::class, mappedBy="auctioneer")
     */
    #[Groups(['update:Auctionner'])]
    #[ApiSubresource(
        maxDepth: 1
    )]
    private $games;

    public function __construct()
    {
        $this->bids = new ArrayCollection();
        $this->games = new ArrayCollection();
    }




    public function getVoluntary(): ?bool
    {
        return $this->voluntary;
    }

    public function setVoluntary(bool $voluntary): self
    {
        $this->voluntary = $voluntary;

        return $this;
    }

    /**
     * @return Collection|Bid[]
     */
    public function getBids(): Collection
    {
        return $this->bids;
    }

    public function addBid(?Bid $bid): self
    {
        if (!$this->bids->contains($bid)) {
            $this->bids[] = $bid;
            $bid->setAuctioneer($this);
        }

        return $this;
    }

    public function removeBid(?Bid $bid): self
    {
        if ($this->bids->removeElement($bid)) {
            // set the owning side to null (unless already changed)
            if ($bid->getAuctioneer() === $this) {
                $bid->setAuctioneer(null);
            }
        }

        return $this;
    }

    public function getAuctionHouse(): ?AuctionHouse
    {
        return $this->auctionHouse;
    }

    public function setAuctionHouse(?AuctionHouse $auctionHouse): self
    {
        $this->auctionHouse = $auctionHouse;

        return $this;
    }

    /**
     * @return Collection|Game[]
     */
    public function getGames(): Collection
    {
        return $this->games;
    }

    public function addGame(?Game $game): self
    {
        if (!$this->games->contains($game)) {
            $this->games[] = $game;
            $game->setAuctioneer($this);
        }

        return $this;
    }

    public function removeGame(Game $game): self
    {
        if ($this->games->removeElement($game)) {
            // set the owning side to null (unless already changed)
            if ($game->getAuctioneer() === $this) {
                $game->setAuctioneer(null);
            }
        }

        return $this;
    }
}
