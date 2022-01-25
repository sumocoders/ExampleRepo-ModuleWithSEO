<?php

namespace Backend\Modules\ExampleLocalised\Domain\Example\Command;

use Backend\Modules\ExampleLocalised\Domain\Example\Example;
use Backend\Modules\ExampleLocalised\Domain\Example\ExampleLocalised;
use Backend\Modules\ExampleLocalised\Domain\Example\ExampleRepository;
use Backend\Modules\ExampleLocalised\Domain\Example\MailchimpData;
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
            $createExample->status,
            $createExample->visible,
            $createExample->sequence
        );

        foreach ($createExample->exampleLocalised as $localised) {
            $translation = new ExampleLocalised(
                $localised->locale,
                $localised->title,
                $localised->meta,
                $localised->description,
                $example
            );

            $example->addExampleLocalised($translation);
        }

        $this->exampleRepository->add($example);

        foreach ($example->getExampleLocalised() as $localised) {
            SearchModel::saveIndex(
                'Example',
                $example->getId(),
                [
                    'title' => $localised->getTitle(),
                    'text' => $localised->getDescription(),
                ],
                'en'
            );
        }


        return $example;
    }
}
