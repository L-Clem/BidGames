<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PurchaseOrderRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=PurchaseOrderRepository::class)
 */

class PurchaseOrder
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    #[Groups(['read:Bid'])]
    private $amount;

    /**
     * @ORM\Column(type="datetime")
     */
    #[Groups(['read:Bid'])]
    private $emissionTime;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="purchaseOrders")
     * @ORM\JoinColumn(nullable=false)
     */
    #[Groups(['read:Bid'])]
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=SaleBid::class, inversedBy="purchaseOrders")
     */
    private $saleBid;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAmount(): ?string
    {
        return $this->amount;
    }

    public function setAmount(string $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getEmissionTime(): ?\DateTimeInterface
    {
        return $this->emissionTime;
    }

    public function setEmissionTime(\DateTimeInterface $emissionTime): self
    {
        $this->emissionTime = $emissionTime;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getSaleBid(): ?SaleBid
    {
        return $this->saleBid;
    }

    public function setSaleBid(?SaleBid $saleBid): self
    {
        $this->saleBid = $saleBid;

        return $this;
    }
}
