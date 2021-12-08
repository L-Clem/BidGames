<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\SaleBidRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=SaleBidRepository::class)
 */
#[ApiResource(
    paginationItemsPerPage: 10,
    paginationMaximumItemsPerPage: 50,
    paginationClientItemsPerPage: true,
    itemOperations: [
        'patch' => [
            'denormalization_context' => ['groups' => ['update:SaleBid', 'create:SaleBid']]
        ],
        'delete',
    ],
    collectionOperations: [

        'post' => [
            'denormalization_context' => ['groups' => ['create:SaleBid']]
        ],
    ],

)]
class SaleBid
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    #[Groups(['read:Sale', 'read:Bid'])]
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    #[Groups(['read:Sale', 'read:Bid', 'update:Bid'])]
    private $sold;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    #[Groups(['read:Sale', 'read:Bid'])]
    private $startingPrice;


    #[Groups(['read:Sale', 'read:Bid', 'update:Bid'])]
    private $soldAtPrice;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    #[Groups(['read:Sale', 'read:Bid'])]
    private $reservePrice;

    /**
     * @ORM\ManyToOne(targetEntity=Bid::class, inversedBy="saleBids")
     * @ORM\JoinColumn(nullable=false)
     */
    #[Groups(['read:Sale'])]
    private $bid;

    /**
     * @ORM\ManyToOne(targetEntity=Sale::class, inversedBy="saleBids")
     * @ORM\JoinColumn(nullable=false)
     */
    #[Groups(['read:Bid'])]
    private $sale;

    /**
     * @ORM\OneToMany(targetEntity=PurchaseOrder::class, mappedBy="saleBid")
     */
    #[Groups(['read:Bid'])]
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
