<?php

namespace Backend\Modules\Example\Actions;

use Backend\Core\Engine\Base\ActionDelete;
use Backend\Core\Engine\Model as BackendModel;
use Backend\Form\Type\DeleteType;
use Backend\Modules\Example\Domain\Example\Command\DeleteExample;
use Backend\Modules\Example\Domain\Example\Command\DeleteEventHandler;
use Backend\Modules\Example\Domain\Example\Example;
use Backend\Modules\Example\Domain\Example\ExampleRepository;

final class EventDelete extends ActionDelete
{
    public function execute(): void
    {
        $event = $this->getEvent();
        if (!$event instanceof Example) {
            $this->redirect($this->getBackLink(['error' => 'non-existing']));

            return;
        }

        $this->get(DeleteEventHandler::class)->handle(new DeleteExample($event));

        $this->redirect($this->getBackLink(['report' => 'deleted', 'var' => $event->getTitle()]));
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
        $deleteForm = $this->createForm(DeleteType::class, null, ['module' => $this->getModule()]);
        $deleteForm->handleRequest($this->getRequest());

        if (!$deleteForm->isSubmitted() || !$deleteForm->isValid()) {
            return null;
        }

        return $this->get(ExampleRepository::class)->find($deleteForm->getData()['id']);
    }
}
