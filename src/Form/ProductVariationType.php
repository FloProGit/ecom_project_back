<?php

namespace App\Form;

use App\Entity\Attribute;
use App\Entity\ConditionProduct;
use App\Entity\Discount;
use App\Entity\Manufacter;
use App\Entity\ProductVariation;
use App\Form\Constraints\LengthConstraint;
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
            ->add('ext_id',TextType::class,['required'=>true,'constraints'=>new LengthConstraint(2,255)])
            ->add('quantity',NumberType::class,['required'=>true])
            ->add('minimal_quantity',NumberType::class,['required'=>true])
            ->add('ean13',TextType::class,['required'=>true,'constraints'=>new LengthConstraint(2,255)])
            ->add('wholesale_price',NumberType::class,['required'=>true])
            ->add('manufacter',EntityType::class,[
                'required'=>true,
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
            ->add('condition_product_id',EntityType::class,[
                'required'=>true,
                'class'=> ConditionProduct::class,
                'label' => 'condition',
                'choice_label' => 'current_condition',
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
            ->add('name',TextType::class,['required'=>true,'constraints'=>new LengthConstraint(2,255)])
            ->add('ext_reference',TextType::class,['required'=>true,'constraints'=>new LengthConstraint(2,255)])
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
