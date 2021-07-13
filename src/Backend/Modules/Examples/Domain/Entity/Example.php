<?php

namespace Backend\Modules\Examples\Domain\Entity;

use Backend\Modules\Examples\Domain\ValueObject\Status;
use Common\Locale;
use Common\Doctrine\Entity\Meta;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Example
{
    /**
     * @var integer
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
     * @var Status
     *
     * @ORM\Column(type="status")
     */
    private $status;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean")
     */
    private $visible;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $sequence;

    /**
     * @var Meta
     *
     * @ORM\OneToOne(targetEntity="Common\Doctrine\Entity\Meta", orphanRemoval=true, cascade={"persist"})
     */
    private $meta;

    /**
     * @var Locale
     *
     * @ORM\Column(type="locale")
     */
    private $locale;

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

    public function __construct(
        string $title,
        Locale $locale,
        Status $status,
        bool $visible,
        int $sequence,
        Meta $meta
    ) {
        $this->title = $title;
        $this->locale = $locale;
        $this->status = $status;
        $this->visible = $visible;
        $this->sequence = $sequence;
        $this->meta = $meta;
    }

    public function update(
        string $title,
        Locale $locale,
        Status $status,
        bool $visible,
        int $sequence,
        Meta $meta
    ) {
        $this->title = $title;
        $this->locale = $locale;
        $this->status = $status;
        $this->visible = $visible;
        $this->sequence = $sequence;
        $this->meta = $meta;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getLocale(): Locale
    {
        return $this->locale;
    }

    public function getStatus(): Status
    {
        return $this->status;
    }

    public function isVisible(): bool
    {
        return $this->visible;
    }

    public function setSequence(int $sequence): void
    {
        $this->sequence = $sequence;
    }

    public function getSequence(): int
    {
        return $this->sequence;
    }

    public function getMeta(): Meta
    {
        return $this->meta;
    }

    public function getCreatedOn(): DateTime
    {
        return $this->createdOn;
    }

    public function getEditedOn(): DateTime
    {
        return $this->editedOn;
    }


    /**
     * @ORM\PrePersist
     */
    public function onPrePersist(): void
    {
        $this->createdOn = new DateTime();
        $this->editedOn = new DateTime();
    }

    /**
     * @ORM\PreUpdate
     */
    public function onPreUpdate(): void
    {
        $this->editedOn = new DateTime();
    }
}
