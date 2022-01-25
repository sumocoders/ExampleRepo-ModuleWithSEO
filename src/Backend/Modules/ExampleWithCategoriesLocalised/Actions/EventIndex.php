<?php

namespace Backend\Modules\Example\Actions;

use Backend\Core\Engine\Base\ActionIndex;
use Backend\Modules\Example\Domain\Example\ExampleDataGrid;
use Backend\Modules\Example\Domain\Example\EventFilterType;
use Backend\Modules\Example\Domain\Example\Filter;

final class EventIndex extends ActionIndex
{
    public function execute(): void
    {
        parent::execute();

        $form = $this->createForm(EventFilterType::class, new Filter());
        $form->handleRequest($this->getRequest());

        $this->template->assign('dataGrid', ExampleDataGrid::getHtml($form->getData()));
        $this->template->assign('filter', $form->createView());

        $this->parse();
        $this->display();
    }
}
