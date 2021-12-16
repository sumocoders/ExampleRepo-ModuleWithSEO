<?php

namespace Backend\Modules\Example\Actions;

use Backend\Core\Engine\Base\ActionEdit;
use Backend\Form\Type\DeleteType;
use Backend\Modules\Example\Domain\Example\Command\UpdateExampleHandler;
use Backend\Modules\Example\Domain\Example\Example;
use Backend\Modules\Example\Domain\Example\Command\UpdateExample;
use Backend\Core\Engine\Model as BackendModel;
use Backend\Modules\Example\Domain\Example\ExampleRepository;
use Backend\Modules\Example\Domain\Example\ExampleType;
use Symfony\Component\Form\Form;

final class EventEdit extends ActionEdit
{
    public function execute(): void
    {
        parent::execute();

        $event = $this->getEvent();

        if (!$event instanceof Example) {
            $this->redirect($this->getBackLink(['error' => 'non-existing']));
        }

        $this->loadDeleteForm($event);

        $form = $this->getForm($event);

        if (!$form->isSubmitted() || !$form->isValid()) {
            $this->template->assign('form', $form->createView());
            $this->template->assign('event', $event);

            $this->parse();
            $this->display();

            return;
        }

        $this->handleForm($form);
    }

    private function loadDeleteForm(Example $event): void
    {
        $deleteForm = $this->createForm(
            DeleteType::class,
            ['id' => $event->getId()],
            [
                'module' => $this->getModule(),
                'action' => 'EventDelete',
            ]
        );

        $this->template->assign('deleteForm', $deleteForm->createView());
    }

    private function getForm(Example $event): Form
    {
        $form = $this->createForm(ExampleType::class, new UpdateExample($event));
        $form->handleRequest($this->getRequest());

        return $form;
    }

    private function handleForm(Form $form): void
    {
        $updateEvent = $form->getData();

        $event = $this->get(UpdateExampleHandler::class)->handle($updateEvent);

        $this->redirect(
            $this->getBackLink(
                [
                    'report' => 'edited',
                    'highlight' => 'row-' . $event->getId(),
                ]
            )
        );
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

    private function getEvent(): ?Example
    {
        return $this->get(ExampleRepository::class)->find($this->getRequest()->query->getInt('id'));
    }
}
