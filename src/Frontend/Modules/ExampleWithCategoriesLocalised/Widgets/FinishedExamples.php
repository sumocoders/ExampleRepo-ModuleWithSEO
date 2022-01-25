<?php

namespace Frontend\Modules\Example\Widgets;

use Backend\Modules\Agenda\Domain\Event\ExampleRepository;
use Frontend\Core\Engine\Base\Widget as FrontendBaseWidget;

/**
 * This is a widget to help you secure a page and make it only accessible for logged-in users.
 */
class FinishedExamples extends FrontendBaseWidget
{
    private $examples;

    public function execute(): void
    {
        parent::execute();
        $this->loadTemplate();

        $this->loadData();
        $this->parse();
    }

    private function loadData(): void
    {
        $this->examples = $this->get(ExampleRepository::class)->findFinishedExamples();
    }

    private function parse(): void
    {
        $this->template->assign(
            'examples',
            $this->examples
        );
    }
}
