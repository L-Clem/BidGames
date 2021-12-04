<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\BidRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BidRepository::class)
 */
#[ApiResource]
class Bid
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $startHour;

    /**
     * @ORM\Column(type="datetime")
     */
    private $endHour;

    /**
     * @ORM\ManyToOne(targetEntity=Auctioneer::class, inversedBy="bids")
     * @ORM\JoinColumn(nullable=false)
     */
    private $auctioneer;

    /**
     * @ORM\OneToOne(targetEntity=Address::class, cascade={"persist", "remove"})
     */
    private $address;

    /**
     * @ORM\OneToMany(targetEntity=SaleBid::class, mappedBy="bid")
     */
    private $saleBids;

    public function __construct()
    {
        $this->saleBids = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartHour(): ?\DateTimeInterface
    {
        return $this->startHour;
    }

    public function setStartHour(\DateTimeInterface $startHour): self
    {
        $this->startHour = $startHour;

        return $this;
    }

    public function getEndHour(): ?\DateTimeInterface
    {
        return $this->endHour;
    }

    public function setEndHour(\DateTimeInterface $endHour): self
    {
        $this->endHour = $endHour;

        return $this;
    }

    public function getAuctioneer(): ?Auctioneer
    {
        return $this->auctioneer;
    }

    public function setAuctioneer(?Auctioneer $auctioneer): self
    {
        $this->auctioneer = $auctioneer;

        return $this;
    }

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function setAddress(?Address $address): self
    {
        $this->address = $address;

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
            $saleBid->setBid($this);
        }

        return $this;
    }

    public function removeSaleBid(SaleBid $saleBid): self
    {
        if ($this->saleBids->removeElement($saleBid)) {
            // set the owning side to null (unless already changed)
            if ($saleBid->getBid() === $this) {
                $saleBid->setBid(null);
            }
        }
        return $this;
    }
}
