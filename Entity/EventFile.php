<?php

namespace Owp\OwpEvent\Entity;

use Doctrine\ORM\Mapping as ORM;
use Owp\OwpEvent\Model as OwpEventTrait;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Entity\File as EmbeddedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity
 * @Vich\Uploadable
 */
class EventFile
{
    use OwpEventTrait\EventReferenceTrait;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
    * @ORM\ManyToOne(targetEntity="Event", inversedBy="files")
    * @ORM\JoinColumn(name="event_id", referencedColumnName="id")
    */
    protected $event;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $type;

    /**
     * @Vich\UploadableField(mapping="event_file", fileNameProperty="fileName", size="fileSize")
     *
     * @var File|null
     */
    private $file;

    /**
     * @ORM\Column(type="string")
     *
     * @var string|null
     */
    private $fileName;

    /**
     * @ORM\Column(type="integer")
     *
     * @var int|null
     */
    private $fileSize;

    public function setFileFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;
    }

    public function getFile(): ?File
    {
        return $this->file;
    }

    public function setFileName(?string $fileName): void
    {
        $this->fileName = $fileName;
    }

    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    public function setFileSize(?int $fileSize): void
    {
        $this->fileSize = $fileSize;
    }

    public function getFileSize(): ?int
    {
        return $this->fileSize;
    }
}
