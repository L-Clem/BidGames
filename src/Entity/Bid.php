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
     * @ORM\OneToOne(targetEntity=Adress::class, cascade={"persist", "remove"})
     */
    private $adress;

    /**
     * @ORM\OneToMany(targetEntity=AnnounceBid::class, mappedBy="bid")
     */
    private $announceBids;

    public function __construct()
    {
        $this->announceBids = new ArrayCollection();
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

    public function getAdress(): ?Adress
    {
        return $this->adress;
    }

    public function setAdress(?Adress $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    /**
     * @return Collection|AnnounceBid[]
     */
    public function getAnnounceBids(): Collection
    {
        return $this->announceBids;
    }

    public function addAnnounceBid(AnnounceBid $announceBid): self
    {
        if (!$this->announceBids->contains($announceBid)) {
            $this->announceBids[] = $announceBid;
            $announceBid->setBid($this);
        }

        return $this;
    }

    public function removeAnnounceBid(AnnounceBid $announceBid): self
    {
        if ($this->announceBids->removeElement($announceBid)) {
            // set the owning side to null (unless already changed)
            if ($announceBid->getBid() === $this) {
                $announceBid->setBid(null);
            }
        }

        return $this;
    }
}
