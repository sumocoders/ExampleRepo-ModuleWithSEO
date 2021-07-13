<?php

namespace Backend\Modules\Examples\Ajax;

use Backend\Core\Engine\Base\AjaxAction;
use Backend\Core\Engine\Model;

use Backend\Core\Language\Language;
use Backend\Modules\Examples\Domain\Entity\Example;
use Backend\Modules\Examples\Domain\ExampleRepository;
use Symfony\Component\HttpFoundation\Response;

class ExampleSequence extends AjaxAction
{
    public function execute(): void
    {
        $newIdSequence = trim($this->getRequest()->request->get('new_id_sequence'));
        $ids = explode(',', rtrim($newIdSequence, ','));

        /** @var ExampleRepository $exampleRepository */
        $exampleRepository = Model::get(ExampleRepository::class);

        // loop id's and set new sequence
        foreach ($ids as $i => $id) {
            $example = $exampleRepository->find((int) $id);

            // update sequence
            if ($example instanceof Example) {
                $example->setSequence($i + 1);

                $exampleRepository->update($example);
            }
        }

        $this->output(Response::HTTP_OK, null, Language::msg('SequenceSaved'));
    }

}
