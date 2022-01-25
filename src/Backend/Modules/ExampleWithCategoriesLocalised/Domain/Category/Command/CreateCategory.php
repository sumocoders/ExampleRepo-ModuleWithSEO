<?php

namespace Backend\Modules\ExampleWithCategoriesLocalised\Domain\Category\Command;

use Backend\Modules\ExampleWithCategoriesLocalised\Domain\Category\CategoryDataTransferObject;

final class CreateCategory extends CategoryDataTransferObject
{
    /**
     * Needed for meta subscriber
     */
    public function getId(): ?int
    {
        return null;
    }
}
