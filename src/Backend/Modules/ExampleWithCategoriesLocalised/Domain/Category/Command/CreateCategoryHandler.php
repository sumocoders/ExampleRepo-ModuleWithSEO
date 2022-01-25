<?php

namespace Backend\Modules\ExampleWithCategoriesLocalised\Domain\Category\Command;

use Backend\Modules\ExampleWithCategoriesLocalised\Domain\Category\Category;
use Backend\Modules\ExampleWithCategoriesLocalised\Domain\Category\CategoryRepository;

final class CreateCategoryHandler
{
    /** @var CategoryRepository */
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function handle(CreateCategory $createCategory): Category
    {
        $category = new Category(
            $createCategory->title,
            $createCategory->meta,
            $this->categoryRepository->getNextSequence()
        );

        $this->categoryRepository->add($category);

        return $category;
    }
}
