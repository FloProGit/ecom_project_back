<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\TaxRule;
use App\Form\Constraints\LengthConstraint;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('ext_id',TextType::class,['required'=>true,'constraints'=>new LengthConstraint(2,255)])
            ->add('name',TextType::class,['required'=>true,'constraints'=>new LengthConstraint(2,255)])
            ->add('width',NumberType::class,['required'=>true])
            ->add('height',NumberType::class,['required'=>true])
            ->add('depth',NumberType::class,['required'=>true])
            ->add('weight',NumberType::class,['required'=>true])
            ->add('ext_reference',TextType::class,['required'=>true,'constraints'=>new LengthConstraint(2,255)])
            ->add('description',TextareaType::class,['required'=>true])
            ->add('short_description',TextType::class,['required'=>true,'constraints'=>new LengthConstraint(2,255)])
            ->add('tax_rule',EntityType::class,[
                'required'=>true,
                'class'=> TaxRule::class,
                'label' => 'tax rule',
                'choice_label' => 'name',
                'mapped' => false
            ])
            ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event): void {
                $product = $event->getData();
                $form = $event->getForm();
                if ($product->isHasVariation()) {
                    return;
                }
                $form->add('productVariations', CollectionType::class, [
                    'entry_type' => ProductVariationType::class,
                ]);
            })
            ->add('submit',SubmitType::class,[
                'translation_domain' => 'button',
                'label' => 'update'
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
