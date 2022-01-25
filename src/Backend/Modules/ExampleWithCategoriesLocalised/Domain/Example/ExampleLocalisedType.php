<?php

namespace Backend\Modules\Agenda\Domain\Event;

use Backend\Form\EventListener\AddMetaSubscriber;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Backend\Form\Type\EditorType;

final class ExampleLocalisedType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add(
            'title',
            TextType::class
        );
        $builder->add(
            'description',
            EditorType::class,
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
        $resolver->setDefaults(['data_class' => ExampleLocalisedDataTransferObject::class]);
    }
}
