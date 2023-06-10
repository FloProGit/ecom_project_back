<?php

namespace App\Form;

use App\Entity\Manufacter;
use App\Form\Constraints\LengthConstraint;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

class ManufacterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('id',HiddenType::class,[
                'disabled' => true,
            ])
            ->add('name',TextType::class,[
                'required'=>true,
                'constraints' => [
                    new NotBlank(),
                    new LengthConstraint(2,255)],
            ])
            ->add('ext_id',NumberType::class,[
                'required'=>true,
                'label' => 'External Id',
                'invalid_message' => 'external ID must be number like (123456) no decimal',
                'constraints' => [
                    new NotBlank(),
                    ],
            ])
            ->add('submit' , SubmitType::class,[
                'translation_domain' => 'button',
                'label' => 'update'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Manufacter::class,
        ]);
    }
}
