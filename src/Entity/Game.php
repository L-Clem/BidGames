<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\GameRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GameRepository::class)
 */
#[ApiResource]
class Game
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="games")
     * @ORM\JoinColumn(nullable=false)
     */
    private $owner;

    /**
     * @ORM\ManyToOne(targetEntity=Auctioneer::class, inversedBy="games")
     */
    private $auctioneer;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    private $estimation;

    /**
     * @ORM\Column(type="boolean")
     */
    private $forSale;

    /**
     * @ORM\ManyToMany(targetEntity=Category::class, mappedBy="game")
     */
    private $categories;

    /**
     * @ORM\ManyToMany(targetEntity=Announce::class, mappedBy="game")
     */
    private $announces;

    /**
     * @ORM\OneToMany(targetEntity=File::class, mappedBy="game")
     */
    private $picture;

    /**
     * @ORM\ManyToOne(targetEntity=DepositAddress::class, inversedBy="game")
     */
    private $depositAddress;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->announces = new ArrayCollection();
        $this->picture = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

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

    public function getEstimation(): ?string
    {
        return $this->estimation;
    }

    public function setEstimation(?string $estimation): self
    {
        $this->estimation = $estimation;

        return $this;
    }

    public function getForSale(): ?bool
    {
        return $this->forSale;
    }

    public function setForSale(bool $forSale): self
    {
        $this->forSale = $forSale;

        return $this;
    }

    /**
     * @return Collection|Category[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
            $category->addGame($this);
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        if ($this->categories->removeElement($category)) {
            $category->removeGame($this);
        }

        return $this;
    }

    /**
     * @return Collection|Announce[]
     */
    public function getAnnounces(): Collection
    {
        return $this->announces;
    }

    public function addAnnounce(Announce $announce): self
    {
        if (!$this->announces->contains($announce)) {
            $this->announces[] = $announce;
            $announce->addGame($this);
        }

        return $this;
    }

    public function removeAnnounce(Announce $announce): self
    {
        if ($this->announces->removeElement($announce)) {
            $announce->removeGame($this);
        }

        return $this;
    }

    /**
     * @return Collection|File[]
     */
    public function getPicture(): Collection
    {
        return $this->picture;
    }

    public function addPicture(File $picture): self
    {
        if (!$this->picture->contains($picture)) {
            $this->picture[] = $picture;
            $picture->setGame($this);
        }

        return $this;
    }

    public function removePicture(File $picture): self
    {
        if ($this->picture->removeElement($picture)) {
            // set the owning side to null (unless already changed)
            if ($picture->getGame() === $this) {
                $picture->setGame(null);
            }
        }

        return $this;
    }

    public function getDepositAddress(): ?DepositAddress
    {
        return $this->depositAddress;
    }

    public function setDepositAddress(?DepositAddress $depositAddress): self
    {
        $this->depositAddress = $depositAddress;

        return $this;
    }
}
