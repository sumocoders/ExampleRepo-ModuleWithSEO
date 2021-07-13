<?php

namespace Backend\Modules\Examples\Domain\MessageHandler;

use Backend\Core\Engine\Model;

use Backend\Modules\Examples\Domain\ExampleRepository;
use Backend\Modules\Examples\Domain\Message\DeleteExample;

class DeleteExampleHandler
{
    private ExampleRepository $exampleRepository;

    public function __construct(ExampleRepository $exampleRepository)
    {
        $this->exampleRepository = $exampleRepository;
    }

    public function __invoke(DeleteExample $deleteExample): void
    {
        // delete widget
        Model::deleteExtraById($deleteExample->getExample()->getId(), true);

        $this->exampleRepository->remove($deleteExample->getExample());
    }
}
