<?php

namespace Backend\Modules\Examples\Domain\DataGrid;

use Backend\Core\Engine\DataGridDatabase;
use Backend\Core\Engine\Authentication as BackendAuthentication;
use Backend\Core\Engine\Model;
use Backend\Core\Language\Language;
use Backend\Core\Language\Locale;

class ExampleDataGrid extends DataGridDatabase
{
    public function __construct()
    {
        parent::__construct(
            'SELECT e.id, e.title
             FROM Example AS e
             ORDER BY e.sequence',
            []
        );

        $this->setAttributes(['data-action' => 'ExamplesSequence']);
        $this->enableSequenceByDragAndDrop();

        if (BackendAuthentication::isAllowedAction('ExampleEdit')) {
            $editUrl = Model::createUrlForAction('ExampleEdit', null, null, ['id' => '[id]'], false);
            $this->setColumnURL('title', $editUrl);
            $this->addColumn('edit', null, Language::lbl('Edit'), $editUrl, Language::lbl('Edit'));
        }
    }

    public static function getHtml(Locale $locale): string
    {
        return (new self($locale))->getContent();
    }

}
