<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\AuctionHouseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AuctionHouseRepository::class)
 */
#[ApiResource]
class AuctionHouse
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
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Auctioneer::class, mappedBy="auctionHouse")
     */
    private $auctioneers;

    /**
     * @ORM\OneToOne(targetEntity=Address::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $address;

    public function __construct()
    {
        $this->auctioneers = new ArrayCollection();
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
     * @return Collection|Auctioneer[]
     */
    public function getAuctioneers(): Collection
    {
        return $this->auctioneers;
    }

    public function addAuctioneer(Auctioneer $auctioneer): self
    {
        if (!$this->auctioneers->contains($auctioneer)) {
            $this->auctioneers[] = $auctioneer;
            $auctioneer->setAuctionHouse($this);
        }

        return $this;
    }

    public function removeAuctioneer(Auctioneer $auctioneer): self
    {
        if ($this->auctioneers->removeElement($auctioneer)) {
            // set the owning side to null (unless already changed)
            if ($auctioneer->getAuctionHouse() === $this) {
                $auctioneer->setAuctionHouse(null);
            }
        }

        return $this;
    }

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function setAddress(Address $address): self
    {
        $this->address = $address;

        return $this;
    }
}
