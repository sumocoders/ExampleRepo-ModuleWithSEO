<?php

namespace Backend\Modules\Examples\Domain\Message;

use Backend\Modules\Examples\Domain\DataTransferObject\ExampleDataTransferObject;
use Backend\Modules\Examples\Domain\Entity\Example;

class DeleteExample
{
    private Example $example;

    public function __construct(Example $example)
    {
        $this->example = $example;
    }

    public function getExample(): Example
    {
        return $this->example;
    }
}
