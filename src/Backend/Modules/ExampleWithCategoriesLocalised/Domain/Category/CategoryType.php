<?php

namespace Backend\Modules\ExampleWithCategoriesLocalised\Domain\Category;

use Backend\Form\EventListener\AddMetaSubscriber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add(
            'title',
            TextType::class,
            [
                'label' => 'lbl.Title',
            ]
        );

        $builder->addEventSubscriber(
            new AddMetaSubscriber(
                'ExampleWithCategoriesLocalised',
                'CategoryDetail',
                CategoryRepository::class,
                'getUrl',
                [
                    'getData.getId',
                ]
            )
        );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => CategoryDataTransferObject::class]);
    }
}
