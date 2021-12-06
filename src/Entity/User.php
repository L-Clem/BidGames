<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
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
        'toggleActivation' => [
            'method' => 'POST',
            'path' => '/auctioneers/{id}/toggleActivation',
            'controller' => UserToggleActivationController::class,
            'openapi_context' => [
                'summary' => 'allow to activate or desactivate an User',
                'requestBody' => [
                    'content' => [
                        'application/json' => [
                            'schema' => [],
                        ]
                    ]
                ]
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



    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): self
    {
        $this->age = $age;

        return $this;
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
}
