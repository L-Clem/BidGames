<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\SaleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SaleRepository::class)
 */
#[ApiResource]
class Sale
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     */
    private $lotNumber;

    /**
     * @ORM\Column(type="datetime")
     */
    private $publishedAt;

    /**
     * @ORM\Column(type="integer")
     */
    private $tax;

    /**
     * @ORM\ManyToMany(targetEntity=Game::class, inversedBy="sales")
     */
    private $game;

    /**
     * @ORM\ManyToMany(targetEntity=User::class)
     */
    private $favorites;

    /**
     * @ORM\OneToOne(targetEntity=File::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $picture;

    /**
     * @ORM\ManyToMany(targetEntity=Tag::class, inversedBy="sales")
     */
    private $tags;

    /**
     * @ORM\OneToMany(targetEntity=SaleBid::class, mappedBy="sale", orphanRemoval=true)
     */
    private $saleBids;

    public function __construct()
    {
        $this->game = new ArrayCollection();
        $this->favorites = new ArrayCollection();
        $this->tags = new ArrayCollection();
        $this->saleBids = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getLotNumber(): ?int
    {
        return $this->lotNumber;
    }

    public function setLotNumber(int $lotNumber): self
    {
        $this->lotNumber = $lotNumber;

        return $this;
    }

    public function getPublishedAt(): ?\DateTimeInterface
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(\DateTimeInterface $publishedAt): self
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }

    public function getTax(): ?int
    {
        return $this->tax;
    }

    public function setTax(int $tax): self
    {
        $this->tax = $tax;

        return $this;
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
        }

        return $this;
    }

    public function removeGame(Game $game): self
    {
        $this->game->removeElement($game);

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getFavorites(): Collection
    {
        return $this->favorites;
    }

    public function addFavorite(User $favorite): self
    {
        if (!$this->favorites->contains($favorite)) {
            $this->favorites[] = $favorite;
        }

        return $this;
    }

    public function removeFavorite(User $favorite): self
    {
        $this->favorites->removeElement($favorite);

        return $this;
    }

    public function getPicture(): ?File
    {
        return $this->picture;
    }

    public function setPicture(File $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * @return Collection|Tag[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        $this->tags->removeElement($tag);

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
            $saleBid->setSale($this);
        }

        return $this;
    }

    public function removeSaleBid(SaleBid $saleBid): self
    {
        if ($this->saleBids->removeElement($saleBid)) {
            // set the owning side to null (unless already changed)
            if ($saleBid->getSale() === $this) {
                $saleBid->setSale(null);
            }
        }

        return $this;
    }
}
