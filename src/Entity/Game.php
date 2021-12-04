<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\GameRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

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
    #[Groups(['read:Sale'])]
    private $estimation;

    /**
     * @ORM\Column(type="boolean")
     */
    private $forSale;

    /**
     * @ORM\ManyToMany(targetEntity=Category::class, mappedBy="game")
     */
    #[Groups(['read:Sale'])]
    private $categories;

    /**
     * @ORM\OneToMany(targetEntity=File::class, mappedBy="game")
     */
    #[Groups(['read:Sale'])]
    private $picture;

    /**
     * @ORM\ManyToOne(targetEntity=DepositAddress::class, inversedBy="game")
     */
    private $depositAddress;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(['read:Sale'])]
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    #[Groups(['read:Sale'])]
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity=Sale::class, mappedBy="game")
     */
    private $sales;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $invisbleFor;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->picture = new ArrayCollection();
        $this->sales = new ArrayCollection();
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

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|Sale[]
     */
    public function getSales(): Collection
    {
        return $this->sales;
    }

    public function addSale(Sale $sale): self
    {
        if (!$this->sales->contains($sale)) {
            $this->sales[] = $sale;
            $sale->addGame($this);
        }

        return $this;
    }

    public function removeSale(Sale $sale): self
    {
        if ($this->sales->removeElement($sale)) {
            $sale->removeGame($this);
        }

        return $this;
    }

    public function getInvisbleFor(): ?string
    {
        return $this->invisbleFor;
    }

    public function setInvisbleFor(string $invisbleFor): self
    {
        $this->invisbleFor = $invisbleFor;

        return $this;
    }
}
