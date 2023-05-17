<?php

namespace App\Form;

use App\Entity\User;
use App\Form\Constraints\LengthConstraint;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email',EmailType::class,['required'=>true,'constraints'=>new LengthConstraint(2,255)])
            ->add(
                'roles', ChoiceType::class, [
                    'required'=>true,
                    'choices' => ['ROLE_ADMIN' => 'ROLE_ADMIN', 'ROLE_USER' => 'ROLE_USER', 'ROLE_CUSTOMER' => 'ROLE_CUSTOMER'],
                    'expanded' => true,
                    'multiple' => true,
                ]
            )
            ->add('created_at',DateType::class,
                ['disabled' => true,'widget' => 'single_text'])
            ->add('name')
            ->add('submit',SubmitType::class,['label' => 'Update'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
