<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\BidRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=BidRepository::class)
 */
#[ApiResource(
    paginationItemsPerPage: 10,
    paginationMaximumItemsPerPage: 50,
    paginationClientItemsPerPage: true,
    itemOperations: [
        'get' => [
            'normalization_context' => ['groups' => ['read:Bid', 'read:Bids']]
        ],
        'patch' => [
            'denormalization_context' => ['groups' => ['update:Bid', 'create:Bid']],
            "security" => "is_granted('ROLE_AUCTIONEER')",
            'summary' => 'Update a bid ressource , can only be use by an auctioneer',
        ],
        'delete' => [
            "security" => "is_granted('ROLE_AUCTIONEER')",
            'summary' => 'delete a bid ressource , can only be use by an auctioneer',
        ],
    ],
    collectionOperations: [
        'get' => [
            'normalization_context' => ['groups' => ['read:Bids']]
        ],
        'post' => [
            'denormalization_context' => ['groups' => ['create:Bid']],
            "security" => "is_granted('ROLE_AUCTIONEER') or is_granted('ROLE_USER')",
            'summary' => 'Create an auctioneer ressource , can only be use by an auctioneer',
        ],
    ],

)]
#[ApiFilter(OrderFilter::class, properties: ['id' => 'ASC'], arguments: ['orderParameterName' => 'order'])]
#[ApiFilter(DateFilter::class, properties: ['startHour', 'endHour'])]
#[ApiFilter(SearchFilter::class, properties: ['id' => 'exact'])]
class Bid
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    #[Groups(['read:Bids'])]
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    #[Groups(['read:Bids', 'create:Bid', 'read:Sale'])]
    private $startHour;

    /**
     * @ORM\Column(type="datetime")
     */
    #[Groups(['read:Bids', 'create:Bid', 'read:Sale'])]
    private $endHour;

    /**
     * @ORM\ManyToOne(targetEntity=Auctioneer::class, inversedBy="bids")
     * @ORM\JoinColumn(nullable=true)
     */
    #[Groups(['read:Bid'])]
    private $auctioneer;

    /**
     * @ORM\OneToOne(targetEntity=Address::class, cascade={"persist", "remove"})
     */
    #[Groups(['read:Bid', 'create:Bid'])]
    private $address;

    /**
     * @ORM\OneToMany(targetEntity=SaleBid::class, mappedBy="bid")
     * @ORM\JoinColumn(nullable=true)
     */
    #[Groups(['read:Bid', 'update:Bid'])]
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
