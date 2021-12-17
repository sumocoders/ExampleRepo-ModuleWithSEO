<?php

namespace Frontend\Modules\Example\Actions;

use Backend\Modules\Agenda\Domain\Event\Example as ExampleEntity;
use Backend\Modules\Agenda\Domain\Event\Event as EventEntity;
use Backend\Modules\Agenda\Domain\Event\ExampleRepository;
use Backend\Modules\Agenda\Domain\Registration\Command\CreateRegistration;
use Backend\Modules\Agenda\Domain\Registration\Command\CreateRegistrationHandler;
use Backend\Modules\Agenda\Domain\Registration\Command\UpdateRegistration;
use Backend\Modules\Agenda\Domain\Registration\Command\UpdateRegistrationHandler;
use Backend\Modules\Agenda\Domain\Registration\Registration;
use Backend\Modules\Agenda\Domain\Registration\RegistrationRepository;
use Backend\Modules\Agenda\Domain\Registration\RegistrationType;
use Backend\Modules\Agenda\Domain\Registration\ScoreType;
use Frontend\Core\Engine\Base\Block as FrontendBaseBlock;
use Frontend\Core\Engine\Navigation;
use Frontend\Core\Language\Locale;
use Frontend\Modules\Profiles\Engine\Authentication as FrontendProfilesAuthentication;
use Frontend\Modules\Profiles\Engine\Profile;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Example extends FrontendBaseBlock
{
    /** @var ExampleEntity */
    private $example;

    public function execute(): void
    {
        parent::execute();
        $this->loadTemplate();
        $this->getData();
        $this->parse();
    }

    private function getData(): void
    {
        if ($this->url->getParameter(0) === null) {
            throw new NotFoundHttpException();
        }

        $this->example = $this->get(ExampleRepository::class)->findBySlug(
            urldecode($this->url->getParameter(0)),
            Locale::frontendLanguage()
        );

        if (!$this->example instanceof EventEntity) {
            throw new NotFoundHttpException();
        }
    }


    private function parse(): void
    {
        $this->template->assign('example', $this->example);
        $this->setMeta($this->example->getContentForLocale(Locale::frontendLanguage())->getMeta());
        $this->addOpenGraphData();
        $this->addTwitterCard();
        $this->header->setCanonicalUrl(
            Navigation::getUrlForBlock('Overview', 'Example') . '/' . $this->example->getContentForLocale(Locale::frontendLanguage())->getMeta()->getUrl()
        );
    }

    private function addOpenGraphData(): void
    {
        $this->header->extractOpenGraphImages($this->example->getContentForLocale(Locale::frontendLanguage())->getDescription());
        $this->header->addOpenGraphData('title', $this->example->getContentForLocale(Locale::frontendLanguage())->getTitle(), true);
        $this->header->addOpenGraphData(
            'url',
            SITE_URL . Navigation::getUrlForBlock('Overview', 'Example') . '/' . $this->example->getContentForLocale(Locale::frontendLanguage())->getMeta()->getUrl(),
            true
        );
        $this->header->addOpenGraphData(
            'site_name',
            $this->get('fork.settings')->get('Core', 'site_title_' . LANGUAGE, SITE_DEFAULT_TITLE),
            true
        );

        $meta = $this->example->getContentForLocale(Locale::frontendLanguage())->getMeta();
        $this->header->addOpenGraphData(
            'description',
            $meta->isDescriptionOverwrite() ? $meta->getDescription() : $this->example->getContentForLocale(Locale::frontendLanguage())->getTitle(),
            true
        );
    }

    private function addTwitterCard(): void
    {
        $this->header->setTwitterCard(
            $this->example->getContentForLocale(Locale::frontendLanguage())->getTitle(),
            $this->example->getContentForLocale(Locale::frontendLanguage())->getMeta()->getDescription(),
            ''
        );
    }
}
