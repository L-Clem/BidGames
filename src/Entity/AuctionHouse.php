<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use App\Repository\AuctionHouseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=AuctionHouseRepository::class)
 */
#[ApiResource(
    paginationItemsPerPage: 10,
    paginationMaximumItemsPerPage: 50,
    paginationClientItemsPerPage: true,
    itemOperations: [
        'get' => [
            'normalization_context' => ['groups' => ['read:AuctionHouse', 'read:AuctionHouses']]
        ],
        'patch' => [
            'denormalization_context' => ['groups' => ['update:AuctionHouse', 'create:AuctionHouse']]
        ],
        'delete',
    ],
    collectionOperations: [
        'get' => [
            'normalization_context' => ['groups' => ['read:AuctionHouses']]
        ],
        'post' => [
            'denormalization_context' => ['groups' => ['create:AuctionHouse']]
        ],
    ],

)]
class AuctionHouse
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    #[Groups(['read:AuctionHouses'])]
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(['read:Auctionner', 'read:AuctionHouses', "create:AuctionHouse", 'read:Bid'])]
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Auctioneer::class, mappedBy="auctionHouse")
     */
    #[ApiSubresource(
        maxDepth: 1,
    )]
    private $auctioneers;

    /**
     * @ORM\OneToOne(targetEntity=Address::class, cascade={"persist"} )
     * 
     */
    #[Groups(['read:Auctionner', 'read:AuctionHouses', 'create:AuctionHouse', 'read:Bid'])]
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
