<?php

namespace Backend\Modules\Example\Domain\Example;

use Backend\Core\Engine\DataGridDatabase;
use Backend\Core\Engine\Authentication as BackendAuthentication;
use Backend\Core\Engine\DataGridFunctions;
use Backend\Core\Engine\Model;
use Backend\Core\Language\Language;

class ExampleDataGrid extends DataGridDatabase
{
    public function __construct()
    {
        $query = 'SELECT e.id, e.title, e.status, e.sequence
                  FROM ExampleExample AS e';
        parent::__construct($query);

        $this->setSortingColumns(['title', 'status'], 'startDate');
        $this->setSortParameter();
        

        if (BackendAuthentication::isAllowedAction('ExampleEdit')) {
            $editUrl = Model::createUrlForAction('ExampleEdit', null, null, ['id' => '[id]'], false);
            $this->setColumnURL('title', $editUrl);
            $this->addColumn('edit', null, Language::lbl('Edit'), $editUrl, Language::lbl('Edit'));
        }
    }

    public static function getHtml(): string
    {
        return (new self())->getContent();
    }

}
