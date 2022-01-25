<?php

namespace Backend\Modules\ExampleWithCategoriesLocalised\Domain\Category;

use Common\Doctrine\Entity\Meta;
use Symfony\Component\Validator\Constraints as Assert;

class CategoryDataTransferObject
{
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
}
