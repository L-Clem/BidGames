<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PersonRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;

/**
 * @ORM\Entity(repositoryClass=PersonRepository::class)
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({
 *       "user" = "User",
 *       "auctioneer" = "Auctioneer"  
 * })
 */
abstract class Person
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    #[Groups(['read:Auctionners'])]
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[
        Groups(['read:Auctionners', 'create:Auctionner']),
        Length(min: 2)
    ]
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[
        Groups(['read:Auctionners', 'create:Auctionner']),
        Length(min: 2)
    ]
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[
        Groups(['read:Auctionners', 'create:Auctionner']),
        Email()
    ]
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(['read:Auctionner', 'create:Auctionner'])]
    private $password;

    /**
     * @ORM\Column(type="boolean",options={"default": "0"})
     */
    #[Groups(['read:Auctionner'])]
    private $desactivated = false;

    /**
     * @ORM\OneToOne(targetEntity=Address::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    #[Groups(['read:Auctionner', 'create:Auctionner'])]
    private $address;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getDesactivated(): ?bool
    {
        return $this->desactivated;
    }

    public function setDesactivated(bool $desactivated): self
    {
        $this->desactivated = $desactivated;

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
