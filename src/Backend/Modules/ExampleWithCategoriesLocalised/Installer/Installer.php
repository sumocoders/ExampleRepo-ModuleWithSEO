<?php

namespace Backend\Modules\Example\Installer;

use Backend\Core\Engine\Model;
use Backend\Core\Installer\ModuleInstaller;
use Backend\Modules\Example\Domain\Category\Category;
use Backend\Modules\Example\Domain\DiscountCode\DiscountCode;
use Backend\Modules\Example\Domain\Example\Example;
use Backend\Modules\Example\Domain\Registration\Registration;
use Common\ModuleExtraType;

final class Installer extends ModuleInstaller
{
    public function install(): void
    {
        $this->addModule('Example');

        $this->importLocale(__DIR__ . '/Data/locale.xml');
        $this->configureEntities();
        $this->configureBackendNavigation();
        $this->configureBackendRights();
        $this->configureFrontendExtras();
    }

    private function configureEntities(): void
    {
        Model::get('fork.entity.create_schema')->forEntityClasses(
            [
                Example::class,
                Category::class,
            ]
        );
    }

    private function configureBackendNavigation(): void
    {
        $navigationModulesId = $this->setNavigation(null, 'Modules');
        $navigationModuleId = $this->setNavigation($navigationModulesId, $this->getModule());
        $this->setNavigation(
            $navigationModuleId,
            'examples',
            'example/index',
            [
                'example/add',
                'example/edit',
            ]
        );

        $this->setNavigation(
            $navigationModuleId,
            'Categories',
            'example/category_index',
            [
                'example/category_add',
                'example/category_edit',
            ]
        );
    }

    private function configureBackendRights(): void
    {
        $this->setModuleRights(1, $this->getModule());

        $this->setActionRights(1, $this->getModule(), 'CategoryAdd');
        $this->setActionRights(1, $this->getModule(), 'CategoryIndex');
        $this->setActionRights(1, $this->getModule(), 'CategoryDelete');
        $this->setActionRights(1, $this->getModule(), 'CategoryEdit');
        $this->setActionRights(1, $this->getModule(), 'ExampleAdd');
        $this->setActionRights(1, $this->getModule(), 'ExampleIndex');
        $this->setActionRights(1, $this->getModule(), 'ExampleDelete');
        $this->setActionRights(1, $this->getModule(), 'ExampleEdit');
    }

    private function configureFrontendExtras(): void
    {
        $this->insertExtra($this->getModule(), ModuleExtraType::block(), 'Categories', 'Categories');
        $this->insertExtra($this->getModule(), ModuleExtraType::block(), 'CategoryDetail', 'Category');
        $this->insertExtra($this->getModule(), ModuleExtraType::block(), 'ExampleDetail', 'Example');
    }
}
