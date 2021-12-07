<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\DepositAddressRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=DepositAddressRepository::class)
 */
#[ApiResource(
    paginationItemsPerPage: 10,
    paginationMaximumItemsPerPage: 50,
    paginationClientItemsPerPage: true,
    itemOperations: [
        'get' => [
            'normalization_context' => ['groups' => ['read:DepositAdress', 'read:DepositAdresses']]
        ],
        'patch' => [
            'denormalization_context' => ['groups' => ['update:DepositAdress', 'create:DepositAdress']]
        ],
        'delete',
    ],
    collectionOperations: [
        'get' => [
            'normalization_context' => ['groups' => ['read:DepositAdresses']]
        ],
        'post' => [
            'denormalization_context' => ['groups' => ['create:DepositAdress']]
        ],
    ],

)]
#[ApiFilter(OrderFilter::class, properties: ['id' => 'ASC', 'game.id' => 'ASC'], arguments: ['orderParameterName' => 'order'])]
#[ApiFilter(SearchFilter::class, properties: ['id' => 'exact', 'game.id' => 'exact'])]
class DepositAddress
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    #[Groups(['read:DepositAdresses'])]
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=Game::class, mappedBy="depositAddress")
     */
    #[Groups(['read:DepositAdresses'])]
    private $game;

    /**
     * @ORM\OneToOne(targetEntity=Address::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    #[Groups(['read:Game', 'create:DepositAdress'])]
    private $address;

    public function __construct()
    {
        $this->game = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Game[]
     */
    public function getGame(): Collection
    {
        return $this->game;
    }

    public function addGame(Game $game): self
    {
        if (!$this->game->contains($game)) {
            $this->game[] = $game;
            $game->setDepositAddress($this);
        }

        return $this;
    }

    public function removeGame(Game $game): self
    {
        if ($this->game->removeElement($game)) {
            // set the owning side to null (unless already changed)
            if ($game->getDepositAddress() === $this) {
                $game->setDepositAddress(null);
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
