<?php

namespace Frontend\Modules\Example\Actions;

use Backend\Modules\Agenda\Domain\Example\ExampleRepository;
use Frontend\Core\Engine\Base\Block as FrontendBaseBlock;
use Frontend\Modules\Profiles\Engine\Profile;

class Overview extends FrontendBaseBlock
{
    /** @var array */
    private $examples;

    public function execute(): void
    {
        parent::execute();
        $this->loadTemplate();

        $this->getData();
        $this->parse();
    }

    private function getData(): void
    {
        $eventRepository = $this->getContainer()->get(ExampleRepository::class);
        $this->examples = $eventRepository->findVisibleExamples(LANGUAGE);
    }

    private function parse(): void
    {
        $this->template->assign('examples', $this->examples);
    }
}
