<?php

namespace Backend\Modules\ExampleWithCategoriesLocalised\Domain\Category\Command;

final class ReSequenceProjects
{
    /**
     * @var int[]
     */
    private $ids;

    public function __construct(array $ids)
    {
        $this->ids = $ids;
    }

    /**
     * @return int[]
     */
    public function getIds(): array
    {
        return $this->ids;
    }
}
