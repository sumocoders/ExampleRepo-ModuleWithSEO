<?php

namespace Backend\Modules\ExampleLocalised\Domain\Example;

use Common\Doctrine\Entity\Meta;
use Doctrine\ORM\Mapping as ORM;

class ExampleLocalised
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
    private $locale;

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
     * @var Example
     *
     * @ORM\ManyToOne(targetEntity="Example", inversedBy="exampleLocalised")
     */
    private $example;

    public function __construct(string $locale, string $title, Meta $meta, ?string $description, Example $example)
    {
        $this->locale = $locale;
        $this->title = $title;
        $this->meta = $meta;
        $this->description = $description;
        $this->example = $example;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLocale(): string
    {
        return $this->locale;
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

    public function getExample(): Example
    {
        return $this->example;
    }
}
