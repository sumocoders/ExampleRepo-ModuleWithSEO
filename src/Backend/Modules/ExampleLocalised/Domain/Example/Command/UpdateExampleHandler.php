<?php

namespace Backend\Modules\Example\Domain\Example\Command;

use Backend\Modules\Example\Domain\Example\Example;
use Backend\Modules\Example\Domain\Example\ExampleRepository;
use Backend\Modules\Search\Engine\Model as SearchModel;
use Backend\Modules\Tags\Engine\Model as TagsModel;
use Common\Doctrine\Repository\MetaRepository;

final class UpdateExampleHandler
{
    /** @var ExampleRepository */
    private $exampleRepository;

    /** @var MetaRepository */
    private $metaRepository;

    public function __construct(ExampleRepository $exampleRepository, MetaRepository $metaRepository)
    {
        $this->exampleRepository = $exampleRepository;
        $this->metaRepository = $metaRepository;
    }

    public function handle(UpdateExample $updateExample): Example
    {
        $example = $updateExample->getExample();

        $example->update(
            $updateExample->title,
            $updateExample->image,
            $updateExample->categories,
            $updateExample->text,
            $updateExample->embedText,
            $updateExample->startDate,
            $updateExample->endDate,
            $updateExample->onlyShowStartDate,
            $updateExample->location,
            $updateExample->price,
            $updateExample->discountForMembers,
            $updateExample->ticketLink,
            $updateExample->facebookLink,
            $updateExample->nlExample,
            $updateExample->nlLink
        );

        $this->exampleRepository->save($example);
        $this->metaRepository->save($example->getMeta());

        SearchModel::saveIndex(
            'Example',
            $example->getId(),
            [
                'title' => $example->getTitle(),
                'text' => $example->getText(),
            ],
            'en'
        );

        return $example;
    }
}
