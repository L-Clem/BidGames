<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\AnnounceBidRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AnnounceBidRepository::class)
 */
#[ApiResource]
class AnnounceBid
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $sold;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $startingPrice;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    private $soldAtPrice;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $reservePrice;

    /**
     * @ORM\ManyToOne(targetEntity=Bid::class, inversedBy="announceBids")
     * @ORM\JoinColumn(nullable=false)
     */
    private $bid;

    /**
     * @ORM\ManyToOne(targetEntity=Announce::class, inversedBy="announceBids")
     * @ORM\JoinColumn(nullable=false)
     */
    private $announce;

    /**
     * @ORM\OneToMany(targetEntity=PurchaseOrder::class, mappedBy="announceBid", orphanRemoval=true)
     */
    private $purchaseOrders;

    public function __construct()
    {
        $this->purchaseOrders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSold(): ?bool
    {
        return $this->sold;
    }

    public function setSold(bool $sold): self
    {
        $this->sold = $sold;

        return $this;
    }

    public function getStartingPrice(): ?string
    {
        return $this->startingPrice;
    }

    public function setStartingPrice(string $startingPrice): self
    {
        $this->startingPrice = $startingPrice;

        return $this;
    }

    public function getSoldAtPrice(): ?string
    {
        return $this->soldAtPrice;
    }

    public function setSoldAtPrice(?string $soldAtPrice): self
    {
        $this->soldAtPrice = $soldAtPrice;

        return $this;
    }

    public function getReservePrice(): ?string
    {
        return $this->reservePrice;
    }

    public function setReservePrice(string $reservePrice): self
    {
        $this->reservePrice = $reservePrice;

        return $this;
    }

    public function getBid(): ?Bid
    {
        return $this->bid;
    }

    public function setBid(?Bid $bid): self
    {
        $this->bid = $bid;

        return $this;
    }

    public function getAnnounce(): ?Announce
    {
        return $this->announce;
    }

    public function setAnnounce(?Announce $announce): self
    {
        $this->announce = $announce;

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
            $purchaseOrder->setAnnounceBid($this);
        }

        return $this;
    }

    public function removePurchaseOrder(PurchaseOrder $purchaseOrder): self
    {
        if ($this->purchaseOrders->removeElement($purchaseOrder)) {
            // set the owning side to null (unless already changed)
            if ($purchaseOrder->getAnnounceBid() === $this) {
                $purchaseOrder->setAnnounceBid(null);
            }
        }

        return $this;
    }
}
