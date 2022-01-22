<?php

namespace App\Entity;

use App\Repository\ColleagueRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Table(name="colleagues")
 * @ORM\Entity(repositoryClass=ColleagueRepository::class)
 * @Vich\Uploadable
 */
class Colleague
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", name="name")
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = "2",
     *      max = "100",
     *      minMessage = "Your first name must be at least {{ limit }} characters length",
     *      maxMessage = "Your first name cannot be longer than {{ limit }} characters length"
     * )
     * @var string
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100, name="email")
     * @Assert\NotBlank()
     * @Assert\Email
     */
    private $email;

    /**
     * @Vich\UploadableField(mapping="colleagues", fileNameProperty="fileName")
     *
     * @var File $file
     * @Assert\Image(
     *     maxSize = "2048k",
     * )
     *
     * @JMS\AccessType("public_method")
     */
    protected $file;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, name="file_name", nullable=true)
     */
    protected $fileName;

    /**
     * @var string
     * @ORM\Column(type="text", name="note", nullable=true)
     */
    protected $note;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="create")
     * @var \DateTime
     */
    protected $created;
    
    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="update")
     * @var \DateTime
     */
    protected $updated;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    public function setFileName(?string $fileName): self
    {
        $this->fileName = $fileName;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function setFile(File $image = null)
    {
        $this->file = $image;

        return $this;
    }

    public function getFile()
    {
        return $this->file;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(?\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }

    public function getUpdated(): ?\DateTimeInterface
    {
        return $this->updated;
    }

    public function setUpdated(?\DateTimeInterface $updated): self
    {
        $this->updated = $updated;

        return $this;
    }
}
