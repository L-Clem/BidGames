<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\PostImageController;
use App\Repository\FileRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File as FileFile;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=FileRepository::class)
 * @Vich\Uploadable
 */
class File
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Vich\UploadableField(mapping="items", fileNameProperty="filePath")
     */
    public ?FileFile $file = null;



    /**
     * @ORM\Column(type="string", length=255)
     * @ORM\JoinColumn(nullable=true)
     */
    public ?string $filePath = null;

    /**
     * 
     * @var string|null
     */
    #[Groups(['read:Sales', 'read:Games', 'read:User', 'read:Sale', 'read:File'])]
    private $fileUrl;

    /**
     * @ORM\ManyToOne(targetEntity=Game::class, inversedBy="picture")
     */
    private $game;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFilePath(): ?string
    {
        return $this->filePath;
    }

    public function setFilePath(string $filePath): self
    {
        $this->filePath = $filePath;

        return $this;
    }

    public function getGame(): ?Game
    {
        return $this->game;
    }

    public function setGame(?Game $game): self
    {
        $this->game = $game;

        return $this;
    }

    /**
     * Get the value of file
     */
    public function getFile(): ?FileFile
    {
        return $this->file;
    }

    /**
     * Set the value of file
     *
     * @return  self
     */
    public function setFile(?FileFile $file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Get the value of fileUrl
     *
     * @return  string|null
     */
    public function getFileUrl()
    {
        return $this->fileUrl;
    }

    /**
     * Set the value of fileUrl
     *
     * @param  string|null  $fileUrl
     *
     * @return  self
     */
    public function setFileUrl($fileUrl)
    {
        $this->fileUrl = $fileUrl;

        return $this;
    }
}
