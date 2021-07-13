<?php

namespace Backend\Modules\Examples\Domain\MessageHandler;

use Backend\Modules\Examples\Domain\Entity\Example;
use Backend\Modules\Examples\Domain\ExampleRepository;
use Backend\Modules\Examples\Domain\Message\UpdateExample;

class UpdateExampleHandler
{
    private ExampleRepository $exampleRepository;

    public function __construct(ExampleRepository $exampleRepository)
    {
        $this->exampleRepository = $exampleRepository;
    }

    public function __invoke(UpdateExample $updateExample): Example
    {
        $example = $updateExample->getExample();
        $example->update(
            $updateExample->title,
            $updateExample->status,
            $updateExample->visible,
            $updateExample->sequence,
            $updateExample->meta
        );

        $this->exampleRepository->update($example);

        return $example;
    }
}
