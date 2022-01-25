<?php

namespace Backend\Modules\ExampleWithCategoriesLocalised\Actions;

use Backend\Core\Engine\Base\ActionAdd;
use Backend\Core\Language\Locale;
use Backend\Modules\ExampleWithCategoriesLocalised\Domain\Category\Command\CreateCategory;
use Backend\Modules\ExampleWithCategoriesLocalised\Domain\Category\CategoryType;
use Backend\Core\Engine\Model as BackendModel;
use Backend\Modules\ExampleWithCategoriesLocalised\Domain\Category\Command\CreateCategoryHandler;
use Symfony\Component\Form\Form;

final class CategoryAdd extends ActionAdd
{
    public function execute(): void
    {
        parent::execute();

        $form = $this->getForm();

        if (!$form->isSubmitted() || !$form->isValid()) {
            $this->template->assign('form', $form->createView());

            $this->parse();
            $this->display();

            return;
        }

        $this->handleForm($form);
    }

    private function handleForm(Form $form): void
    {
        $createCategory = $form->getData();

        $category = $this->get(CreateCategoryHandler::class)->handle($createCategory);

        $this->redirect(
            $this->getBackLink(
                [
                    'report' => 'added',
                    'hightlight' => 'row-' . $category->getId(),
                ]
            )
        );
    }

    private function getForm(): Form
    {
        $form = $this->createForm(CategoryType::class, new CreateCategory());
        $form->handleRequest($this->getRequest());

        return $form;
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
}
