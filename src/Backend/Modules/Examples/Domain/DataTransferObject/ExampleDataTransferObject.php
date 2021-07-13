<?php

namespace Backend\Modules\Examples\Domain\DataTransferObject;

use Backend\Modules\Examples\Domain\ValueObject\Status;
use Common\Doctrine\Entity\Meta;
use DateTime;
use Symfony\Component\Validator\Constraints as Assert;

class ExampleDataTransferObject
{
    public $id;

    /**
     * @Assert\NotBlank(message="err.FieldIsRequired")
     */
    public $title;

    public $locale;

    public $status;

    public $visible;

    public $sequence;

    /**
     * @Assert\NotBlank(message="err.FieldIsRequired")
     */
    public $meta;

    public $createdOn;

    public $editedOn;

    public function getId()
    {
        return $this->id;
    }

    public function getLocale()
    {
        return $this->locale;
    }
}
