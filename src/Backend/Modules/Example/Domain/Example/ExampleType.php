<?php

namespace Backend\Modules\Agenda\Domain\Event;

use Backend\Core\Language\Language;
use Backend\Form\EventListener\AddMetaSubscriber;
use Backend\Modules\Agenda\Domain\Category\Category;
use Backend\Modules\Agenda\Domain\Event\Image\Image;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Common\Form\ImageType;
use Backend\Form\Type\EditorType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

final class ExampleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add(
            'title',
            TextType::class
        );
        $builder->add(
            'status',
            ChoiceType::class,
            [
                'choices' => Status::ALL,
                'choice_value' => function (?string $status) {
                    if ($status === null) {
                        return null;
                    }

                    return new Status($status);
                }
            ]
        );
        $builder->add(
            'description',
            EditorType::class,
            [
                'required' => false,
            ]
        );
        $builder->add(
            'visible',
            CheckboxType::class,
            [
                'required' => false,
            ]
        );

        $builder->addEventSubscriber(
            new AddMetaSubscriber(
                'Example',
                'Detail',
                ExampleRepository::class,
                'getUrl',
                [
                    'getData.getId',
                ]
            )
        );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => ExampleDataTransferObject::class]);
    }
}
