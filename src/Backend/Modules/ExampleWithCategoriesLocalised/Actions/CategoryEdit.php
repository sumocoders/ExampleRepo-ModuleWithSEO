<?php

namespace Backend\Modules\ExampleWithCategoriesLocalised\Actions;

use Backend\Core\Engine\Base\ActionEdit;
use Backend\Form\Type\DeleteType;
use Backend\Modules\ExampleWithCategoriesLocalised\Domain\Category\Category;
use Backend\Modules\ExampleWithCategoriesLocalised\Domain\Category\Command\UpdateCategory;
use Backend\Core\Engine\Model as BackendModel;
use Backend\Modules\ExampleWithCategoriesLocalised\Domain\Category\CategoryRepository;
use Backend\Modules\ExampleWithCategoriesLocalised\Domain\Category\CategoryType;
use Backend\Modules\ExampleWithCategoriesLocalised\Domain\Category\Command\UpdateCategoryHandler;
use Symfony\Component\Form\Form;

final class CategoryEdit extends ActionEdit
{
    public function execute(): void
    {
        parent::execute();

        $category = $this->getCategory();

        if (!$category instanceof Category) {
            $this->redirect($this->getBackLink(['error' => 'non-existing']));
        }

        $this->loadDeleteForm($category);

        $form = $this->getForm($category);

        if (!$form->isSubmitted() || !$form->isValid()) {
            $this->template->assign('form', $form->createView());
            $this->template->assign('category', $category);

            $this->parse();
            $this->display();

            return;
        }

        $this->handleForm($form);
    }

    private function loadDeleteForm(Category $category): void
    {
        $deleteForm = $this->createForm(
            DeleteType::class,
            ['id' => $category->getId()],
            [
                'module' => $this->getModule(),
                'action' => 'CategoryDelete',
            ]
        );

        $this->template->assign('deleteForm', $deleteForm->createView());
    }

    private function getForm(Category $category): Form
    {
        $form = $this->createForm(CategoryType::class, new UpdateCategory($category));
        $form->handleRequest($this->getRequest());

        return $form;
    }

    private function handleForm(Form $form): void
    {
        $updateCategory = $form->getData();

        $category = $this->get(UpdateCategoryHandler::class)->handle($updateCategory);

        $this->redirect(
            $this->getBackLink(
                [
                    'report' => 'edited',
                    'highlight' => 'row-' . $category->getId(),
                ]
            )
        );
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
        return $this->get(CategoryRepository::class)->find($this->getRequest()->query->getInt('id'));
    }
}
