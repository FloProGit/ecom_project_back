<?php

namespace App\Form;

use App\Entity\ConditionProduct;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class ConditionProductListType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
//        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
//
//            $conditionProducts = $event->getData();
//            $form = $event->getForm();
//            foreach ($conditionProducts as $conditionProduct)
//            {
//                $form->add('condition', ConditionProduct::class);
//            }
//
//        });
        $builder->add('condition_products', CollectionType::class, [
            'entry_type' => ConditionProductType::class,
            'entry_options' => ['label' => false],
            'allow_add' => true,
            'allow_delete' => true,
        ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
