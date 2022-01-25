<?php

namespace Backend\Modules\Example\Domain\Example;

use Backend\Modules\Example\Domain\Example\Status\Status;
use Backend\Modules\ExampleLocalised\Domain\Example\ExampleLocalised;
use Common\Doctrine\Entity\Meta;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

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

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="ExampleLocalised", mappedBy="example", cascade={"persist", "remove"})
     */
    private $exampleLocalised;

    public function __construct(
        Status $status,
        bool $visible,
        int $sequence,
        Collection $exampleLocalised = null
    ) {
        $this->status = $status;
        $this->visible = $visible;
        $this->sequence = $sequence;

        $this->exampleLocalised = new ArrayCollection();
        if ($exampleLocalised instanceof Collection) {
            $this->exampleLocalised = $exampleLocalised;
        }
    }

    public function update(
        bool $visible,
        int $sequence,
        Collection $exampleLocalised = null
    ) {
        $this->visible = $visible;
        $this->sequence = $sequence;

        $this->exampleLocalised = new ArrayCollection();
        if ($exampleLocalised instanceof Collection) {
            $this->exampleLocalised = $exampleLocalised;
        }
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function addExampleLocalised(ExampleLocalised $exampleLocalised): void
    {
        if ($this->exampleLocalised->contains($exampleLocalised)) {
            return;
        }

        $this->exampleLocalised->add($exampleLocalised);
    }

    public function getContentForLocale(string $locale): ?ExampleLocalised
    {
        foreach ($this->exampleLocalised as $exampleLocalised) {
            if ($exampleLocalised->getLocale() === $locale) {
                return $exampleLocalised;
            }
        }

        return null;
    }

    /**
     * @return Collection
     */
    public function getExampleLocalised(): Collection
    {
        return $this->exampleLocalised;
    }
}
