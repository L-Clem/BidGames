<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PurchaseOrderRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PurchaseOrderRepository::class)
 */
#[ApiResource]
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
    private $amount;

    /**
     * @ORM\Column(type="datetime")
     */
    private $emissionTime;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="purchaseOrders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=AnnounceBid::class, inversedBy="purchaseOrders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $announceBid;

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

    public function getAnnounceBid(): ?AnnounceBid
    {
        return $this->announceBid;
    }

    public function setAnnounceBid(?AnnounceBid $announceBid): self
    {
        $this->announceBid = $announceBid;

        return $this;
    }
}
