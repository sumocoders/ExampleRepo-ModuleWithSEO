<?php

namespace Backend\Modules\ExampleWithCategoriesLocalised\Actions;

use Backend\Core\Engine\Base\ActionDelete;
use Backend\Core\Engine\Model as BackendModel;
use Backend\Form\Type\DeleteType;
use Backend\Modules\ExampleWithCategoriesLocalised\Domain\Category\Command\DeleteCategory;
use Backend\Modules\ExampleWithCategoriesLocalised\Domain\Category\Category;
use Backend\Modules\ExampleWithCategoriesLocalised\Domain\Category\CategoryRepository;
use Backend\Modules\ExampleWithCategoriesLocalised\Domain\Category\Command\DeleteCategoryHandler;

final class CategoryDelete extends ActionDelete
{
    public function execute(): void
    {
        $category = $this->getCategory();
        if (!$category instanceof Category) {
            $this->redirect($this->getBackLink(['error' => 'non-existing']));

            return;
        }

        $this->get(DeleteCategoryHandler::class)->handle(new DeleteCategory($category));

        $this->redirect($this->getBackLink(['report' => 'deleted', 'var' => $category->getTitle()]));
    }

    private function getBackLink(array $parameters = []): string
    {
        return BackendModel::createUrlForAction(
            'CategoryIndex',
            null,
            null,
            $parameters
        );
    }

    private function getCategory(): ?Category
    {
        $deleteForm = $this->createForm(DeleteType::class, null, ['module' => $this->getModule()]);
        $deleteForm->handleRequest($this->getRequest());

        if (!$deleteForm->isSubmitted() || !$deleteForm->isValid()) {
            return null;
        }

        return $this->get(CategoryRepository::class)->find($deleteForm->getData()['id']);
    }
}
