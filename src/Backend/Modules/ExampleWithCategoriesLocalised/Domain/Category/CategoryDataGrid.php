<?php

namespace Backend\Modules\ExampleWithCategoriesLocalised\Domain\Category;

use Backend\Core\Engine\DataGridDatabase;
use Backend\Core\Engine\Authentication as BackendAuthentication;
use Backend\Core\Engine\Model;
use Backend\Core\Language\Language;
use Backend\Core\Language\Locale;

class CategoryDataGrid extends DataGridDatabase
{
    public function __construct()
    {
        parent::__construct(
            'SELECT c.id, c.title, c.sequence
             FROM ExampleWithCategoriesLocalisedCategory AS c'
        );

        $this->enableSequenceByDragAndDrop();
        $this->setAttributes(['data-action' => 'CategorySequence']);

        if (BackendAuthentication::isAllowedAction('CategoryEdit')) {
            $editUrl = Model::createUrlForAction('CategoryEdit', null, null, ['id' => '[id]'], false);
            $this->setColumnURL('title', $editUrl);
            $this->addColumn('edit', null, Language::lbl('Edit'), $editUrl, Language::lbl('Edit'));
        }
    }

    public static function getHtml(): string
    {
        return (new self())->getContent();
    }
}
