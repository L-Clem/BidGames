<?php

namespace App\Entity;

use ApiPlatform\Core\Action\NotFoundAction;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\MeController;
use App\Repository\IndividualRepository;
use Doctrine\ORM\Mapping as ORM;

use Lexik\Bundle\JWTAuthenticationBundle\Security\User\JWTUserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints\Length;

/**
 * @ORM\Entity(repositoryClass=IndividualRepository::class)
 *  * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({
 *       "user" = "User",
 *       "auctioneer" = "Auctioneer"  
 * 
 * })
 */
#[ApiResource(
    collectionOperations: [
        'me' => [
            'pagination_enabled' => false,
            'path' => '/me',
            'method' => 'get',
            'controller' => MeController::class,
            'read' => false,
            'security' => 'is_granted("ROLE_USER")',
            'openapi_context' => [
                'security' => [['bearerAuth' => []]]
            ]
        ],
    ],
    itemOperations: [
        'get' => [
            'controller' => NotFoundAction::class,
            'openapi_context' => ['summary' => 'hidden'],
            'read' => false,
            'output' => false
        ]
    ],
    normalizationContext: ['groups' => ['read:Individual']]

)]

class Individual implements UserInterface, PasswordAuthenticatedUserInterface, JWTUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    #[Groups(['read:Auctionners', 'read:Individual'])]
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    #[
        Groups(['read:Auctionners', 'create:Auctionner', 'read:Individual']),
        Length(min: 2)
    ]
    private $email;

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
     * @ORM\Column(type="json")
     */
    #[Groups(['read:Individual'])]
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * 
     * @SerializedName("password")
     */
    #[Groups(['create:Auctionner'])]
    private $plainPassword;

    /**
     * @ORM\Column(type="boolean",options={"default": "0"})
     */
    #[Groups(['read:Auctionner'])]
    private $desactivated = false;

    /**
     * @ORM\OneToOne(targetEntity=Address::class, cascade={"persist", "remove"})
     *
     */
    #[Groups(['read:Auctionner', 'create:Auctionner'])]
    private $address;


    public function getId(): ?int
    {
        return $this->id;
    }


    public function setId(?int $id): self
    {
        $this->id = $id;
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


    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(?array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public static function createFromPayload($id, array $payload)
    {
        $individual = new Individual();
        $individual->setId($id);
        $individual->setEmail($payload['email'] ?? '');

        return $individual;
    }

    /**
     * Get the value of plainPassword
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * Set the value of plainPassword
     *
     * @return  self
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }
}
