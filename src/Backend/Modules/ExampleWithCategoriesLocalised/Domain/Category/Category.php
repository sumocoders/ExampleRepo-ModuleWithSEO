<?php

namespace Backend\Modules\ExampleWithCategoriesLocalised\Domain\Category;

use Common\Doctrine\Entity\Meta;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="ExampleWithCategoriesLocalisedCategory")
 * @ORM\Entity(repositoryClass="Backend\Modules\ExampleWithCategoriesLocalised\Domain\Category\CategoryRepository")
 */
class Category
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $title;

    /**
     * @var Meta
     *
     * @ORM\OneToOne(targetEntity="Common\Doctrine\Entity\Meta", cascade={"persist","remove"})
     */
    private $meta;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $sequence;

    /**
     * @var DateTime
     *
     * @ORM\Column(type="datetime")
     */
    private $createdOn;

    /**
     * @var DateTime
     *
     * @ORM\Column(type="datetime")
     */
    private $editedOn;

    /**
     * @var Collection
     *
     * @ORM\ManyToMany(targetEntity="Backend\Modules\ExampleWithCategoriesLocalised\Domain\Event\Event", mappedBy="categories")
     */
    private $events;

    public function __construct(string $title, Meta $meta, int $sequence)
    {
        $this->title = $title;
        $this->meta = $meta;
        $this->sequence = $sequence;
        $this->events = new ArrayCollection();

        $this->createdOn = new DateTime();
        $this->editedOn = new DateTime();
    }

    public function update(string $title): void
    {
        $this->title = $title;

        $this->editedOn = new DateTime();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getMeta(): Meta
    {
        return $this->meta;
    }

    public function setSequence(int $sequence): void
    {
        $this->sequence = $sequence;
    }

    public function getSequence(): int
    {
        return $this->sequence;
    }

    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function getCreatedOn(): DateTime
    {
        return $this->createdOn;
    }

    public function getEditedOn(): DateTime
    {
        return $this->editedOn;
    }
}
