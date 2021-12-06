<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\AddressRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=AddressRepository::class)
 */

class Address
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="smallint")
     */
    #[Groups(['read:Auctionner', 'read:AuctionHouses', "create:AuctionHouse", 'create:Auctionner', 'create:DepositAdress', 'read:User', 'create:User', 'read:Bids'])]
    private $streetNumber;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(['read:Auctionner', 'read:AuctionHouses', "create:AuctionHouse", 'create:Auctionner', 'create:DepositAdress', 'read:User', 'create:User', 'read:Bids'])]
    private $streetName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    #[Groups(['read:Auctionner', 'read:AuctionHouses', "create:AuctionHouse", 'create:Auctionner', 'create:DepositAdress', 'read:User', 'create:User', 'read:Bids'])]
    private $addressComplement;

    /**
     * @ORM\OneToOne(targetEntity=Bid::class)
     * * @ORM\JoinColumn(nullable=true)
     */
    private $bid;

    /**
     * @ORM\ManyToOne(targetEntity=City::class, inversedBy="addresses")
     * @ORM\JoinColumn(nullable=false)
     */
    private $city;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStreetNumber(): ?int
    {
        return $this->streetNumber;
    }

    public function setStreetNumber(int $streetNumber): self
    {
        $this->streetNumber = $streetNumber;

        return $this;
    }

    public function getStreetName(): ?string
    {
        return $this->streetName;
    }

    public function setStreetName(string $streetName): self
    {
        $this->streetName = $streetName;

        return $this;
    }

    public function getAddressComplement(): ?string
    {
        return $this->addressComplement;
    }

    public function setAddressComplement(?string $addressComplement): self
    {
        $this->addressComplement = $addressComplement;

        return $this;
    }



    public function getCity(): ?City
    {
        return $this->city;
    }

    public function setCity(?City $city): self
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get the value of bid
     */
    public function getBid()
    {
        return $this->bid;
    }

    /**
     * Set the value of bid
     *
     * @return  self
     */
    public function setBid($bid)
    {
        $this->bid = $bid;

        return $this;
    }
}
