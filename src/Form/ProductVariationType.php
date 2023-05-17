<?php

namespace App\Form;

use App\Entity\Attribute;
use App\Entity\Discount;
use App\Entity\Manufacter;
use App\Entity\ProductVariation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
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
            ->add('manufacter',EntityType::class,[
                'class'=> Manufacter::class,
                'label' => 'Manufacter',
                'choice_label' => 'name',
                'mapped' => false
            ])
            ->add('attribute',EntityType::class,[
                'class'=> Attribute::class,
                'label' => 'attribute',
                'choice_label' => 'name',
            ])
            ->add('discount_id',EntityType::class,[
                'class'=> Discount::class,
                'label' => 'discount',
                'choice_label' => 'value',
            ])
            ->add('on_sale',CheckboxType::class,[
                'required' => false,
            ])
            ->add('images',FileType::class,[
                'label' => false,
                'multiple'=> true,
                'mapped'=>false,
                'required' => false
            ])
            ->add('price_tax_exclude',NumberType::class)
            ->add('name',TextType::class)
            ->add('ext_reference',TextType::class)
            ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event): void {
                $productVariation = $event->getData();
                $form = $event->getForm();
                if (!$productVariation->getProductId()->isHasVariation()) {
                    return;
                }
                $form->add('submit',SubmitType::class);
            })
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ProductVariation::class,
        ]);
    }
}
