<?php

namespace Backend\Modules\Examples\Actions;

use Backend\Core\Engine\Base\ActionAdd;
use Backend\Core\Engine\Model as BackendModel;
use Backend\Modules\Examples\Domain\Form\ExampleType;
use Backend\Modules\Examples\Domain\Message\CreateExample;
use Backend\Modules\Examples\Domain\MessageHandler\CreateExampleHandler;
use Symfony\Component\Form\Form;

class ExampleAdd extends ActionAdd
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
        /** @var CreateExampleHandler $handler */
        $handler = $this->get(CreateExampleHandler::class);
        $example = $handler($form->getData());

        $this->redirect(
            $this->getBackLink(
                [
                    'report' => 'added',
                    'highlight' => 'row-' . $example->getId(),
                ]
            )
        );
    }

    private function getForm(): Form
    {
        $form = $this->createForm(ExampleType::class, new CreateExample());
        $form->handleRequest($this->getRequest());

        return $form;
    }

    private function getBackLink(array $parameters = []): string
    {
        return BackendModel::createUrlForAction(
            'ExampleIndex',
            null,
            null,
            $parameters
        );
    }
}
