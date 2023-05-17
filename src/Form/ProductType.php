<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\TaxRule;
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
            ->add('ext_id',TextType::class)
            ->add('name',TextType::class)
            ->add('width',NumberType::class)
            ->add('height',NumberType::class)
            ->add('depth',NumberType::class)
            ->add('weight',NumberType::class)
            ->add('ext_reference',TextType::class)
            ->add('description',TextareaType::class)
            ->add('short_description',TextType::class)
            ->add('tax_rule',EntityType::class,[
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
            ->add('submit',SubmitType::class);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
