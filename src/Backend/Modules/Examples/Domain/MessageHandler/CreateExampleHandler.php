<?php

namespace Backend\Modules\Examples\Domain\MessageHandler;

use Backend\Modules\Examples\Domain\Entity\Example;
use Backend\Modules\Examples\Domain\ExampleRepository;
use Backend\Modules\Examples\Domain\Message\CreateExample;

class CreateExampleHandler
{
    private ExampleRepository $exampleRepository;

    public function __construct(ExampleRepository $exampleRepository)
    {
        $this->exampleRepository = $exampleRepository;
    }

    public function __invoke(CreateExample $createExample): Example
    {
        $example = new Example(
            $createExample->title,
            $createExample->status,
            $createExample->visible,
            $createExample->sequence,
            $createExample->meta
        );

        $this->exampleRepository->add($example);

        return $example;
    }
}
