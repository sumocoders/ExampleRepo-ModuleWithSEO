<?php

namespace Backend\Modules\Example\Domain\Example\Command;

use Backend\Modules\Example\Domain\Example\Example;
use Backend\Modules\Example\Domain\Example\ExampleRepository;
use Backend\Modules\Example\Domain\Example\MailchimpData;
use Backend\Modules\Search\Engine\Model as SearchModel;
use Backend\Modules\Tags\Engine\Model as TagsModel;
use Mailchimp\Mailchimp;
use Symfony\Component\Translation\TranslatorInterface;

final class CreateExampleHandler
{
    /** @var ExampleRepository */
    private $exampleRepository;

    public function __construct(ExampleRepository $exampleRepository)
    {
        $this->exampleRepository = $exampleRepository;
    }

    public function handle(CreateExample $createExample): Example
    {
        $example = new Example(
            $createExample->title,
            $createExample->meta,
            $createExample->image,
            $createExample->categories,
            $createExample->text,
            $createExample->embedText,
            $createExample->startDate,
            $createExample->endDate,
            $createExample->onlyShowStartDate,
            $createExample->location,
            $createExample->price,
            $createExample->discountForMembers,
            $createExample->ticketLink,
            $result->get('id'),
            $createExample->facebookLink,
            $createExample->nlExample,
            $createExample->nlLink
        );

        $this->exampleRepository->add($example);

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
