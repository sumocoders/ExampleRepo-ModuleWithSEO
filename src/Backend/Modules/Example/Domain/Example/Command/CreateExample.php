<?php

namespace Backend\Modules\Example\Domain\Example\Command;

use Backend\Modules\Example\Domain\Example\ExampleDataTransferObject;

final class CreateExample extends ExampleDataTransferObject
{
    /**
     * Needed for meta subscriber
     */
    public function getId(): ?int
    {
        return null;
    }
}
