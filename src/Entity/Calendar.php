<?php

namespace App\Entity;

use App\Repository\CalendarRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\CallbackValidator;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


/**
 * @ORM\Entity(repositoryClass=CalendarRepository::class)
 */
class Calendar
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     *
     */
    private $fileName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imageFilename;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $PublishedAt;

    /**
     * @ORM\OneToMany(targetEntity=CategoryReference::class, mappedBy="calendar")
     * @ORM\OrderBy({"position"="ASC"})
     */
    private $categoryReferences;

    public function __construct()
    {
        $this->categoryReferences = new ArrayCollection();
    }
    
    public function getId()
    {
        return $this->id;
    }

    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    public function setFileName(string $fileName): self
    {
        $this->fileName = $fileName;

        return $this;
    }

    public function __toString()
    {
        return $this->getFileName();
    }

    public function getImageFilename(): ?string
    {
        return $this->imageFilename;
    }

    public function setImageFilename(?string $imageFilename): self
    {
        $this->imageFilename = $imageFilename;

        return $this;
    }

    public function getImagePath()
    {
        return 'uploads/calendar_image/'.$this->getImageFilename();
    }

    public function getPublishedAt(): ?bool
    {
        return $this->PublishedAt;
    }

    public function setPublishedAt(?bool $PublishedAt): self
    {
        $this->PublishedAt = $PublishedAt;
        return $this;
    }

    public function isPublished(): ?bool
    {
        return $this->PublishedAt;
    }

    /**
     * @return Collection|CategoryReference[]
     */
    public function getCategoryReferences(): Collection
    {
        return $this->categoryReferences;
    }

}