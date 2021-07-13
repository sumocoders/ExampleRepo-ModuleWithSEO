<?php

namespace Backend\Modules\Examples\Actions;

use Backend\Core\Engine\Base\ActionIndex;
use Backend\Core\Language\Locale;
use Backend\Modules\Examples\Domain\DataGrid\ExampleDataGrid;

class ExampleIndex extends ActionIndex
{
    public function execute(): void
    {
        parent::execute();

        $this->template->assign('dataGrid', ExampleDataGrid::getHtml(Locale::workingLocale()));

        $this->parse();
        $this->display();
    }

}
