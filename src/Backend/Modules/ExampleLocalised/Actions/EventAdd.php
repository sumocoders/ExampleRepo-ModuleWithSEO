<?php

namespace Backend\Modules\Example\Actions;

use Backend\Core\Engine\Base\ActionAdd;
use Backend\Core\Language\Language;
use Backend\Core\Language\Locale;
use Backend\Modules\Example\Domain\Example\Command\CreateExample;
use Backend\Modules\Example\Domain\Example\Command\CreateExampleHandler;
use Backend\Modules\Example\Domain\Example\ExampleType;
use Backend\Core\Engine\Model as BackendModel;
use Symfony\Component\Form\Form;

final class EventAdd extends ActionAdd
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
        $createEvent = $form->getData();

        $event = $this->get(CreateExampleHandler::class)->handle($createEvent);

        $this->redirect(
            $this->getBackLink(
                [
                    'report' => 'added',
                    'highlight' => 'row-' . $event->getId(),
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
            'EventIndex',
            null,
            null,
            $parameters
        );
    }
}
