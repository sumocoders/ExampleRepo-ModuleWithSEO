<?php

namespace Backend\Modules\ExampleWithCategoriesLocalised\Domain\Category\Command;

use Backend\Modules\ExampleWithCategoriesLocalised\Domain\Category\Category;
use Backend\Modules\ExampleWithCategoriesLocalised\Domain\Category\CategoryRepository;
use Common\Doctrine\Repository\MetaRepository;

final class UpdateCategoryHandler
{
    /** @var CategoryRepository */
    private $categoryRepository;

    /** @var MetaRepository */
    private $metaRepository;

    public function __construct(CategoryRepository $categoryRepository, MetaRepository $metaRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->metaRepository = $metaRepository;
    }

    public function handle(UpdateCategory $updateCategory): Category
    {
        $category = $updateCategory->getCategory();

        $category->update($updateCategory->title);

        $this->categoryRepository->save($category);
        $this->metaRepository->save($category->getMeta());

        return $category;
    }
}
