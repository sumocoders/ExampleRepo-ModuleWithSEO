<?php

namespace Backend\Modules\Examples\Installer;

use Backend\Core\Engine\Model;
use Backend\Core\Installer\ModuleInstaller;
use Backend\Modules\Examples\Domain\Entity\Example;

final class Installer extends ModuleInstaller
{
    public function install(): void
    {
        $this->addModule('Examples');

        $this->importLocale(__DIR__ . '/Data/locale.xml');
        $this->configureEntities();
        $this->configureSettings();
        $this->configureBackendNavigation();
        $this->configureBackendRights();
        $this->configureFrontendExtras();
    }

    private function configureEntities(): void
    {
        Model::get('fork.entity.create_schema')->forEntityClasses(
            [
                Example::class
            ]
        );
    }

    private function configureSettings(): void
    {
        // $this->setSetting($this->getModule(), '[setting_name]', [setting_value]);
    }

    private function configureBackendNavigation(): void
    {
        $navigationModulesId = $this->setNavigation(null, 'Modules');
        $navigationModuleId = $this->setNavigation($navigationModulesId, $this->getModule());
        $this->setNavigation(
            $navigationModuleId,
            'Examples',
            'examples/example_index',
            [
                'examples/example_add',
                'examples/example_edit'
            ]
        );
    }

    private function configureBackendRights(): void
    {
        $this->setModuleRights(1, $this->getModule());

        $this->setActionRights(1, $this->getModule(), 'ExampleAdd');
        $this->setActionRights(1, $this->getModule(), 'ExampleIndex');
        $this->setActionRights(1, $this->getModule(), 'ExampleDelete');
        $this->setActionRights(1, $this->getModule(), 'ExampleEdit');
        $this->setActionRights(1, $this->getModule(), 'ExampleSequence');
    }

    private function configureFrontendExtras(): void
    {
        /* Module Action template
        $this->insertExtra($this->getModule(), ModuleExtraType::block(), [label], [action]);
        */
        /* Module Widget template
        $this->insertExtra($this->getModule(), ModuleExtraType::widget(), [label], [action]);
        */
    }
}
