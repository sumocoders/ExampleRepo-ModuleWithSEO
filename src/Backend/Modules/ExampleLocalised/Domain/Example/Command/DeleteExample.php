<?php

namespace Backend\Modules\Example\Domain\Example\Command;

use Backend\Modules\Example\Domain\Example\Example;

final class DeleteExample
{
    /** @var Example */
    private $example;

    public function __construct(Example $example)
    {
        $this->example = $example;
    }

    public function getExample(): Example
    {
        return $this->example;
    }
}
