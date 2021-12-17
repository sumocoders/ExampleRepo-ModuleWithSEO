<?php

namespace Backend\Modules\Example\Domain\Example\Command;

use Backend\Modules\Example\Domain\Example\ExampleDataTransferObject;
use Backend\Modules\Example\Domain\Example\Example;
use Backend\Modules\Tags\Engine\Model as TagsModel;

final class UpdateExample extends ExampleDataTransferObject
{
    /** @var Example */
    private $example;

    public function __construct(Example $example)
    {
        $this->example = $example;
        $this->status = $example->getStatus();
        $this->visible = $example->isVisible();
        $this->sequence = $example->getSequence();
        $this->title = $example->getTitle();
        $this->meta = $example->getMeta();
        $this->description = $example->getDescription();
    }

    public function getExample(): Example
    {
        return $this->example;
    }

    /**
     * Needed for meta subscriber
     */
    public function getId(): int
    {
        return $this->example->getId();
    }
}
