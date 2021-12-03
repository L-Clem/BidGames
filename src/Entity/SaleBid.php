<?php

namespace App\Entity;

use App\Repository\SaleBidRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SaleBidRepository::class)
 */
class SaleBid
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
     * @ORM\ManyToOne(targetEntity=Bid::class, inversedBy="saleBids")
     * @ORM\JoinColumn(nullable=false)
     */
    private $bid;

    /**
     * @ORM\ManyToOne(targetEntity=sale::class, inversedBy="saleBids")
     * @ORM\JoinColumn(nullable=false)
     */
    private $sale;

    /**
     * @ORM\OneToMany(targetEntity=purchaseOrder::class, mappedBy="saleBid")
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

    public function getSale(): ?sale
    {
        return $this->sale;
    }

    public function setSale(?sale $sale): self
    {
        $this->sale = $sale;

        return $this;
    }

    /**
     * @return Collection|purchaseOrder[]
     */
    public function getPurchaseOrders(): Collection
    {
        return $this->purchaseOrders;
    }

    public function addPurchaseOrder(purchaseOrder $purchaseOrder): self
    {
        if (!$this->purchaseOrders->contains($purchaseOrder)) {
            $this->purchaseOrders[] = $purchaseOrder;
            $purchaseOrder->setSaleBid($this);
        }

        return $this;
    }

    public function removePurchaseOrder(purchaseOrder $purchaseOrder): self
    {
        if ($this->purchaseOrders->removeElement($purchaseOrder)) {
            // set the owning side to null (unless already changed)
            if ($purchaseOrder->getSaleBid() === $this) {
                $purchaseOrder->setSaleBid(null);
            }
        }

        return $this;
    }
}
