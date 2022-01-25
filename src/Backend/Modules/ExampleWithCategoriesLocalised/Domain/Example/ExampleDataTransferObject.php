<?php

namespace Backend\Modules\Example\Domain\Example;

use Backend\Modules\Example\Domain\Example\Status\Status;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;

class ExampleDataTransferObject
{
    /**
     * @var Status
     *
     * @Assert\NotNull(message="err.FieldIsRequired")
     */
    public $status;

    /**
     * @var bool
     */
    public $visible;

    /**
     * @var int
     */
    public $sequence = 9999;

    /**
     * @var array|Collection
     *
     * @Assert\Valid()
     */
    public $exampleLocalised;
}
