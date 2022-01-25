<?php

namespace Backend\Modules\ExampleWithCategoriesLocalised\Domain\Category\Command;

use Backend\Modules\ExampleWithCategoriesLocalised\Domain\Category\CategoryRepository;

final class ReSequenceProjectsHandler
{
    /** @var CategoryRepository */
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function handle(ReSequenceProjects $reSequenceProjects): bool
    {
        foreach ($reSequenceProjects->getIds() as $sequence => $id) {
            $project = $this->categoryRepository->find($id);

            if ($project === null) {
                continue;
            }

            $project->setSequence($sequence + 1);
        }

        $this->categoryRepository->flush();

        return true;
    }
}
