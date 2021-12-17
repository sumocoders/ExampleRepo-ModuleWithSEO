<?php

namespace Backend\Modules\Agenda\Domain\Event;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class ExampleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
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
            'visible',
            CheckboxType::class,
            [
                'required' => false,
            ]
        );

        $builder->add(
            'exampleLocalised',
            CollectionType::class,
            [
                'entry_type' => ExampleLocalisedType::class
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
