<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;

use App\Controller\UserChooseDepositAddress;
use App\Controller\UserChooseDepositAdress;
use App\Controller\UserMakePurchaseOrder;
use App\Controller\Userverify;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * 
 */
#[ApiResource(
    paginationItemsPerPage: 10,
    paginationMaximumItemsPerPage: 50,
    paginationClientItemsPerPage: true,
    itemOperations: [
        'get' => [
            'normalization_context' => ['groups' => ['read:User', 'read:Users']]
        ],
        'patch' => [
            'denormalization_context' => ['groups' => ['update:User', 'create:User']]
        ],
        'delete',
        'chooseDepositAdress' => [
            'method' => 'POST',
            'path' => '/users/chooseDepositAdress/{gameId}',
            'controller' => UserChooseDepositAddress::class,
            "security" => "is_granted('ROLE_USER')",
            "read" => false,
            'openapi_context' => [
                'summary' => 'allow to  choose a deposit Adress When you buy a game (Check if the game is sold and if you are the owner)',
                'requestBody' => [
                    'content' => [
                        'application/json' => [
                            'schema' => [
                                'type' => "object",
                                "properties" => [
                                    "DepositAdress" => [
                                        "type" => "string",

                                    ]
                                ]
                            ],
                        ]
                    ]
                ]
            ]
        ],
        'makePurchaseOrder' => [
            'method' => 'POST',
            'path' => '/users/makePurchaseOrder/{SalesBidId}',
            'controller' => UserMakePurchaseOrder::class,
            "security" => "is_granted('ROLE_USER')",
            "read" => false,
            'openapi_context' => [
                'summary' => 'allow  a user to make a purchaseorder on a salesBid',
                'requestBody' => [
                    'content' => [
                        'application/json' => [
                            'schema' => [
                                'type' => "object",
                                "properties" => [
                                    "amount" => [
                                        "type" => "number",

                                    ]

                                ]
                            ],
                        ]
                    ]
                ]
            ]
        ],
        'verifyUser' => [
            'method' => 'POST',
            'controller' => Userverify::class,
            'path' => 'admin/users/verify/{id}',
            'openapi_context' => [
                'tags' => ["Admin/User"],
            ]
        ],

    ],
    collectionOperations: [
        'get' => [
            'normalization_context' => ['groups' => ['read:Users']]
        ],
        'post' => [
            'denormalization_context' => ['groups' => ['create:User']]
        ],
    ],

)]
#[ApiFilter(OrderFilter::class, properties: ['id' => 'ASC', 'lastname' => 'ASC', 'verified' => 'ASC'], arguments: ['orderParameterName' => 'order'])]
#[ApiFilter(SearchFilter::class, properties: ['id' => 'exact', 'lastname' => 'partial'])]
class User extends Individual
{


    /**
     * @ORM\Column(type="date")
     * @Groups({"person:read", "person:write"})
     */
    #[Groups(['read:Users', 'create:User'])]
    private $BirthDate;

    /**
     * @ORM\Column(type="boolean",options={"default": "0"})
     * @Groups({"person:read", "person:write"})
     */
    private $verified = false;

    /**
     * @ORM\OneToMany(targetEntity=Game::class, mappedBy="owner", orphanRemoval=true)
     * @Groups({"person:read", "person:write"})
     */
    #[ApiSubresource(
        maxDepth: 1,
    )]
    private $games;

    /**
     * @ORM\OneToMany(targetEntity=PurchaseOrder::class, mappedBy="user", orphanRemoval=true)
     * @ORM\JoinColumn(nullable=true)
     */
    private $purchaseOrders;

    public function __construct()
    {
        $this->games = new ArrayCollection();
        $this->purchaseOrders = new ArrayCollection();
    }



    public function getVerified(): ?bool
    {
        return $this->verified;
    }

    public function setVerified(bool $verified): self
    {
        $this->verified = $verified;

        return $this;
    }

    /**
     * @return Collection|Game[]
     */
    public function getGames(): Collection
    {
        return $this->games;
    }

    public function addGame(Game $game): self
    {
        if (!$this->games->contains($game)) {
            $this->games[] = $game;
            $game->setOwner($this);
        }

        return $this;
    }

    public function removeGame(Game $game): self
    {
        if ($this->games->removeElement($game)) {
            // set the owning side to null (unless already changed)
            if ($game->getOwner() === $this) {
                $game->setOwner(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|PurchaseOrder[]
     */
    public function getPurchaseOrders(): Collection
    {
        return $this->purchaseOrders;
    }

    public function addPurchaseOrder(PurchaseOrder $purchaseOrder): self
    {
        if (!$this->purchaseOrders->contains($purchaseOrder)) {
            $this->purchaseOrders[] = $purchaseOrder;
            $purchaseOrder->setUser($this);
        }

        return $this;
    }

    public function removePurchaseOrder(PurchaseOrder $purchaseOrder): self
    {
        if ($this->purchaseOrders->removeElement($purchaseOrder)) {
            // set the owning side to null (unless already changed)
            if ($purchaseOrder->getUser() === $this) {
                $purchaseOrder->setUser(null);
            }
        }

        return $this;
    }

    /**
     * Get the value of BirthDate
     */
    public function getBirthDate()
    {
        return $this->BirthDate;
    }

    /**
     * Set the value of BirthDate
     *
     * @return  self
     */
    public function setBirthDate($BirthDate)
    {
        $this->BirthDate = $BirthDate;

        return $this;
    }
}
