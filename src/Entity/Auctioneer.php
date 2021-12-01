<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\AuctioneerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AuctioneerRepository::class)
 */
#[ApiResource]
class Auctioneer extends Person
{

    /**
     * @ORM\Column(type="boolean")
     */
    private $voluntary;

    /**
     * @ORM\OneToMany(targetEntity=Bid::class, mappedBy="auctioneer")
     */
    private $bids;

    /**
     * @ORM\ManyToOne(targetEntity=AuctionHouse::class, inversedBy="auctioneers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $auctionHouse;

    /**
     * @ORM\OneToOne(targetEntity=Adress::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $adress;

    /**
     * @ORM\OneToMany(targetEntity=Game::class, mappedBy="auctioneer")
     */
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

    public function addBid(Bid $bid): self
    {
        if (!$this->bids->contains($bid)) {
            $this->bids[] = $bid;
            $bid->setAuctioneer($this);
        }

        return $this;
    }

    public function removeBid(Bid $bid): self
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

    public function getAdress(): ?Adress
    {
        return $this->adress;
    }

    public function setAdress(Adress $adress): self
    {
        $this->adress = $adress;

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
