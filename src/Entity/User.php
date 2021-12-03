<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * 
 */
#[ApiResource]
class User extends Individual
{


    /**
     * @ORM\Column(type="integer")
     * @Groups({"person:read", "person:write"})
     */
    private $age;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"person:read", "person:write"})
     */
    private $verified;

    /**
     * @ORM\OneToMany(targetEntity=Game::class, mappedBy="owner", orphanRemoval=true)
     * @Groups({"person:read", "person:write"})
     */
    private $games;

    /**
     * @ORM\ManyToMany(targetEntity=Announce::class, mappedBy="favorites")
     * @Groups({"person:read", "person:write"})
     */
    private $favorites;

    /**
     * @ORM\OneToMany(targetEntity=PurchaseOrder::class, mappedBy="user", orphanRemoval=true)
     */
    private $purchaseOrders;

    public function __construct()
    {
        $this->games = new ArrayCollection();
        $this->favorites = new ArrayCollection();
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
     * @return Collection|Announce[]
     */
    public function getFavorites(): Collection
    {
        return $this->favorites;
    }

    public function addFavorite(Announce $favorite): self
    {
        if (!$this->favorites->contains($favorite)) {
            $this->favorites[] = $favorite;
            $favorite->addFavorite($this);
        }

        return $this;
    }

    public function removeFavorite(Announce $favorite): self
    {
        if ($this->favorites->removeElement($favorite)) {
            $favorite->removeFavorite($this);
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
