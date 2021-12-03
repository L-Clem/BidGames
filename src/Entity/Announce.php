<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Controller\AnnounceCountFavorites;
use App\Repository\AnnounceRepository;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * 
 * @ORM\Entity(repositoryClass=AnnounceRepository::class)
 */
#[ApiResource(
    paginationItemsPerPage: 10,
    paginationMaximumItemsPerPage: 50,
    paginationClientItemsPerPage: true,
    itemOperations: [
        'get' => [
            'normalization_context' => ['groups' => ['read:Announce', 'read:Announces']]
        ],
        'patch' => [
            'denormalization_context' => ['groups' => ['update:Announce', 'create:Announce']]
        ],
        'delete',
        'countFavorites' => [
            'method' => 'GET',
            'path' => '/announces/{id}/favorites/count',
            'controller' => AnnounceCountFavorites::class,
            'openapi_context' => [
                'summary' => 'Give you the favorites users number who favorite your announce ',
                'responses' => [
                    '200' => [
                        'description' => 'OK',
                        'content' => [
                            'application/json' => [
                                'schema' => [
                                    'type' => 'integer',
                                    'example' => 5
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ],
    collectionOperations: [
        'get' => [
            'normalization_context' => ['groups' => ['read:Announces']]
        ],
        'post' => [
            'denormalization_context' => ['groups' => ['create:Announce']]
        ],
    ],
)]
#[ApiFilter(
    SearchFilter::class,
    properties: ['title' => 'partial', 'game.title' => 'partial', 'tag.name' => 'partial'],
)]

#[ApiFilter(
    DateFilter::class,
    properties: ['publishedAt']
)]

class Announce
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
    #[Groups(['read:Announces', 'create:Announce'])]
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(['read:Announces', 'create:Announce'])]
    private $description;

    /**
     * @ORM\Column(type="integer")
     */
    #[Groups(['read:Announce', 'create:Announce'])]
    private $lotNumber;

    /**
     * @ORM\Column(type="datetime")
     */
    #[Groups(['read:Announces'])]
    private $publishedAt;

    /**
     * @ORM\Column(type="integer")
     */
    #[Groups(['read:Announce', 'create:Announce'])]
    private $tax;

    /**
     * @ORM\ManyToMany(targetEntity=Game::class, inversedBy="announces")
     * @ORM\JoinColumn(nullable=false)
     */
    #[Groups(['read:Announce', 'create:Announce'])]
    #[ApiSubresource()]
    private $game;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="favorites")
     * @ORM\JoinColumn(nullable=true)
     */
    #[Groups(['read:Announce', 'create:Announce'])]
    private $favorites;

    /**
     * @ORM\OneToOne(targetEntity=File::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    #[Groups(['read:Announces', 'create:Announce'])]
    private $Picture;

    /**
     * @ORM\ManyToMany(targetEntity=Tag::class, mappedBy="announce")
     */
    #[Groups(['read:Announce', 'create:Announce'])]
    #[ApiSubresource()]
    private $tags;

    /**
     * @ORM\OneToMany(targetEntity=AnnounceBid::class, mappedBy="announce")
     * @ORM\JoinColumn(nullable=true)
     */
    #[Groups(['read:Announce', 'create:Announce'])]
    #[ApiSubresource()]
    private $announceBids;

    public function __construct()
    {
        $this->game = new ArrayCollection();
        $this->favorites = new ArrayCollection();
        $this->tags = new ArrayCollection();
        $this->announceBids = new ArrayCollection();
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
        return $this->Picture;
    }

    public function setPicture(File $Picture): self
    {
        $this->Picture = $Picture;

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
            $tag->addAnnounce($this);
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        if ($this->tags->removeElement($tag)) {
            $tag->removeAnnounce($this);
        }

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
            $announceBid->setAnnounce($this);
        }

        return $this;
    }

    public function removeAnnounceBid(AnnounceBid $announceBid): self
    {
        if ($this->announceBids->removeElement($announceBid)) {
            // set the owning side to null (unless already changed)
            if ($announceBid->getAnnounce() === $this) {
                $announceBid->setAnnounce(null);
            }
        }

        return $this;
    }
}
