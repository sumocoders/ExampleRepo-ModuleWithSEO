<?php

namespace Backend\Modules\Example\Domain\Example;

use Backend\Modules\Example\Domain\Example\Image\Image;
use Backend\Modules\Example\Domain\Example\Status\Status;
use Common\Doctrine\Entity\Meta;
use DateTime;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;

class ExampleLocalisedDataTransferObject
{
    /**
     * Needed for meta subscriber
     */
    public function getId(): ?int
    {
        return null;
    }

    public $id;

    /**
     * @var string
     *
     * @Assert\NotBlank(message="err.FieldIsRequired")
     */
    public $title;

    /**
     * @var Meta
     */
    public $meta;

    /**
     * @var string
     */
    public $description;
}
