<?php

namespace Backend\Modules\Example\Domain\Example;

use Backend\Modules\Example\Domain\Example\Image\Image;
use Backend\Modules\Example\Domain\Example\Status\Status;
use Backend\Modules\Example\Domain\Registration\Registration;
use Common\Doctrine\Entity\Meta;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Frontend\Modules\Profiles\Engine\Profile;

/**
 * @ORM\Table(name="ExampleExample")
 * @ORM\Entity(repositoryClass="Backend\Modules\Example\Domain\Example\ExampleRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Example
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
     * @var string|null
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @var Status
     *
     * @ORM\Column(type="example_status")
     */
    private $status;

    /**
     * @var bool
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

    public function __construct(
        string $title,
        Meta $meta,
        string $description,
        Status $status,
        bool $visible,
        int $sequence
    ) {
        $this->title = $title;
        $this->meta = $meta;
        $this->description = $description;
        $this->status = $status;
        $this->visible = $visible;
        $this->sequence = $sequence;
    }

    public function update(
        string $title,
        Meta $meta,
        string $description,
        Status $status,
        bool $visible,
        int $sequence
    ) {
        $this->title = $title;
        $this->meta = $meta;
        $this->description = $description;
        $this->status = $status;
        $this->visible = $visible;
        $this->sequence = $sequence;
    }

    public function getId(): ?int
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getStatus(): Status
    {
        return $this->status;
    }

    public function isVisible(): bool
    {
        return $this->visible;
    }

    public function getSequence(): int
    {
        return $this->sequence;
    }
}
