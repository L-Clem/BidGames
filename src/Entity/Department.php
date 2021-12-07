<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\DepartmentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=DepartmentRepository::class)
 */
#[ApiResource(
    paginationItemsPerPage: 10,
    paginationMaximumItemsPerPage: 50,
    paginationClientItemsPerPage: true,
    itemOperations: [
        'get' => [
            'normalization_context' => ['groups' => ['read:Department', 'read:Departments']]
        ],
        'patch' => [
            'path' => 'admin/departments/{id}',
            'normalization_context' => ['groups' => ['create:Department']],
            'openapi_context' => [
                'tags' => ["Admin/Department"],
            ]
        ],
        'delete' => [
            'path' => 'admin/departments/{id}',
            'openapi_context' => [
                'tags' => ["Admin/Department"],
            ]
        ],
    ],
    collectionOperations: [
        'get' => [
            'normalization_context' => ['groups' => ['read:Departments']]
        ],
        'post' => [
            'path' => 'admin/departments',
            'normalization_context' => ['groups' => ['create:Department']],
            'openapi_context' => [
                'tags' => ["Admin/Department"],
            ]
        ],
    ],
)]
class Department
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    #[Groups(["read:Departments", 'read:City'])]
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(["read:Departments", 'read:City'])]
    private $code;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(["read:Departments", 'read:City'])]
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=Region::class, inversedBy="departments")
     * @ORM\JoinColumn(nullable=false)
     */
    #[Groups(["read:Departments"])]
    private $region;

    /**
     * @ORM\OneToMany(targetEntity=City::class, mappedBy="Department", orphanRemoval=true)
     */
    private $cities;

    public function __construct()
    {
        $this->cities = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
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

    public function getRegion(): ?Region
    {
        return $this->region;
    }

    public function setRegion(?Region $region): self
    {
        $this->region = $region;

        return $this;
    }

    /**
     * @return Collection|City[]
     */
    public function getCities(): Collection
    {
        return $this->cities;
    }

    public function addCity(City $city): self
    {
        if (!$this->cities->contains($city)) {
            $this->cities[] = $city;
            $city->setDepartment($this);
        }

        return $this;
    }

    public function removeCity(City $city): self
    {
        if ($this->cities->removeElement($city)) {
            // set the owning side to null (unless already changed)
            if ($city->getDepartment() === $this) {
                $city->setDepartment(null);
            }
        }

        return $this;
    }
}
