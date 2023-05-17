<?php

namespace App\Form;

use App\Entity\TaxRule;
use App\Form\Constraints\LengthConstraint;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaxRuleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('id',HiddenType::class,[
                'disabled' => true,
            ])
            ->add('code_tax',NumberType::class,['required'=>true])
            ->add('name',TextType::class,['required'=>true,'constraints'=>new LengthConstraint(2,255)])
            ->add('submit',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TaxRule::class,
        ]);
    }
}
