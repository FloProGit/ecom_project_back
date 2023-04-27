<?php

namespace App\Form;

use App\Entity\ProductVariation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductVariationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('ext_id',TextType::class)
            ->add('quantity',NumberType::class)
            ->add('minimal_quantity',NumberType::class)
            ->add('ean13',TextType::class)
            ->add('wholesale_price',NumberType::class)
            ->add('on_sale',CheckboxType::class)
            ->add('price_tax_exclude',NumberType::class)
            ->add('name',TextType::class)
            ->add('ext_reference',TextType::class)
            ->add('is_main',CheckboxType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ProductVariation::class,
        ]);
    }
}
