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
use Gedmo\Mapping\Annotation as Gedmo;


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
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $PublishedAt;

    /**
     * @ORM\OneToMany(targetEntity=CategoryReference::class, mappedBy="calendar")
     * @ORM\OrderBy({"position"="ASC"})
     */
    private $categoryReferences;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $slug;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $content;

    public function __construct()
    {
        $this->categoryReferences = new ArrayCollection();
    }
    
    public function getId()
    {
        return $this->id;
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

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

}