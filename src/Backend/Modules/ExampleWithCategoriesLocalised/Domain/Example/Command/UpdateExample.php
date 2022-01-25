<?php

namespace Backend\Modules\ExampleLocalised\Domain\Example\Command;

use Backend\Modules\Example\Domain\Example\ExampleLocalisedDataTransferObject;
use Backend\Modules\ExampleLocalised\Domain\Example\ExampleDataTransferObject;
use Backend\Modules\ExampleLocalised\Domain\Example\Example;
use Backend\Modules\ExampleLocalised\Domain\Example\ExampleLocalised;
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
        $this->exampleLocalised = array_map(
            function (ExampleLocalised $exampleLocalised) {
                $dto = new ExampleLocalisedDataTransferObject();
                $dto->id = $exampleLocalised->getId();
                $dto->description = $exampleLocalised->getDescription();
                $dto->title = $exampleLocalised->getTitle();
                $dto->meta = $exampleLocalised->getMeta();

                return $dto;
            },
            $example->getExampleLocalised()
        );
    }

    public function getExample(): Example
    {
        return $this->example;
    }
}
