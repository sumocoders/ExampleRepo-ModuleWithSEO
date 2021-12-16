<?php

namespace Backend\Modules\Example\Domain\Example\Command;

use Backend\Modules\Example\Domain\Example\ExampleDataTransferObject;
use Backend\Modules\Example\Domain\Example\Example;
use Backend\Modules\Tags\Engine\Model as TagsModel;

final class UpdateExample extends ExampleDataTransferObject
{
    /** @var Example */
    private $example;

    public function __construct(Example $example)
    {
        $this->example = $example;

        $this->title = $example->getTitle();
        $this->meta = $example->getMeta();
        $this->image = $example->getImage();
        $this->categories = $example->getCategories();
        $this->text = $example->getText();
        $this->embedText = $example->getEmbedText();
        $this->startDate = $example->getStartDate();
        $this->endDate = $example->getEndDate();
        $this->onlyShowStartDate = $example->onlyShowStartDate();
        $this->location = $example->getLocation();
        $this->price = $example->getPrice();
        $this->discountForMembers = $example->getDiscountForMembers();
        $this->ticketLink = $example->getTicketLink();
        $this->tags = TagsModel::getTags('Example', $example->getId());
        $this->facebookLink = $example->getFacebookLink();
        $this->nlExample = $example->isNlExample();
        $this->nlLink = $example->getNlLink();
    }

    public function getExample(): Example
    {
        return $this->example;
    }

    /**
     * Needed for meta subscriber
     */
    public function getId(): int
    {
        return $this->example->getId();
    }
}
