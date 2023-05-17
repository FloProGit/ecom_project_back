<?php

namespace App\Form;

use App\Entity\Discount;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DiscountType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('id', HiddenType::class, [
                'disabled' => true,
            ])
            ->add('value', NumberType::class, ['required' => true, 'label' => 'value'])
            ->add('discount_from', DateTimeType::class, ['widget' => 'single_text','required' => true, 'input' => 'datetime_immutable'])
            ->add('discount_to', DateTimeType::class, ['widget' => 'single_text', 'required' => true,'input' => 'datetime_immutable'])
            ->add('submit', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Discount::class,
        ]);
    }
}
