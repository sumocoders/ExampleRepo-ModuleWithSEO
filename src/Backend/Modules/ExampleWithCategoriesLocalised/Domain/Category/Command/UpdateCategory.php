<?php

namespace Backend\Modules\ExampleWithCategoriesLocalised\Domain\Category\Command;

use Backend\Modules\ExampleWithCategoriesLocalised\Domain\Category\CategoryDataTransferObject;
use Backend\Modules\ExampleWithCategoriesLocalised\Domain\Category\Category;

final class UpdateCategory extends CategoryDataTransferObject
{
    /** @var Category */
    private $category;

    public function __construct(Category $category)
    {
        $this->category = $category;

        $this->title = $category->getTitle();
        $this->meta = $category->getMeta();
    }

    public function getCategory(): Category
    {
        return $this->category;
    }

    /**
     * Needed for meta subscriber
     */
    public function getId(): int
    {
        return $this->category->getId();
    }
}
