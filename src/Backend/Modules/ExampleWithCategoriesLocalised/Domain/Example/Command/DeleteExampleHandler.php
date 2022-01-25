<?php

namespace Backend\Modules\Example\Domain\Example\Command;

use Backend\Modules\Example\Domain\Example\ExampleRepository;
use Backend\Modules\Search\Engine\Model as SearchModel;
use Backend\Modules\Tags\Engine\Model as TagsModel;

final class DeleteExampleHandler
{
    /** @var ExampleRepository */
    private $exampleRepository;

    public function __construct(ExampleRepository $exampleRepository)
    {
        $this->exampleRepository = $exampleRepository;
    }

    public function handle(DeleteExample $deleteExample): void
    {
        SearchModel::removeIndex(
            'Example',
            $deleteExample->getExample()->getId(),
            'en'
        );

        TagsModel::saveTags($deleteExample->getExample()->getId(), '', 'Example');
        $this->exampleRepository->remove($deleteExample->getExample());
    }
}
