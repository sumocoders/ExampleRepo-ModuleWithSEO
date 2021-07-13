<?php

namespace Backend\Modules\Examples\Domain\Message;

use Backend\Modules\Examples\Domain\DataTransferObject\ExampleDataTransferObject;
use Backend\Modules\Examples\Domain\Entity\Example;

class UpdateExample extends ExampleDataTransferObject
{
    private Example $example;

    public function __construct(Example $example)
    {
        $this->example = $example;
        $this->locale = $example->getLocale();
        $this->status = $example->getStatus();
        $this->id = $example->getId();
        $this->createdOn = $example->getCreatedOn();
        $this->meta = $example->getMeta();
        $this->editedOn = $example->getEditedOn();
        $this->sequence = $example->getSequence();
        $this->title = $example->getTitle();
        $this->visible = $example->isVisible();
    }

    public function getExample(): Example
    {
        return $this->example;
    }
}
