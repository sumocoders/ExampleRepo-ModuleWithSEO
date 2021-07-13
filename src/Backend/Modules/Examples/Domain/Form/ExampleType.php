<?php

namespace Backend\Modules\Examples\Domain\Form;

use Backend\Form\EventListener\AddMetaSubscriber;
use Backend\Form\Type\MetaType;
use Backend\Modules\Examples\Domain\DataTransferObject\ExampleDataTransferObject;
use Backend\Modules\Examples\Domain\ExampleRepository;
use Backend\Modules\Examples\Domain\ValueObject\Status;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExampleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'title',
                TextType::class,
                [
                    'label' => 'lbl.Title',
                    'required' => true,
                ]
            )
            ->add(
                'status',
                ChoiceType::class,
                [
                    'label' => 'lbl.Status',
                    'required' => true,
                    'choices' => Status::choices()
                ]
            )
            ->add(
                'visible',
                CheckboxType::class,
                [
                    'label' => 'lbl.Visible',
                    'required' => false,
                ]
            );

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => ExampleDataTransferObject::class]);
    }

}
