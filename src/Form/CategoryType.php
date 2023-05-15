<?php

namespace App\Form;

use App\Entity\Category;
use App\Form\Constraints\LengthConstraint;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryType extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('is_active', CheckboxType::class, ['required' => false])
            ->add('name', TextType::class, [
                    'required' => true,
                    'constraints' => [new LengthConstraint(5,255),]
                ]
            )
            ->add('id_parent', NumberType::class, ['required' => true])
            ->add('parent', TextType::class, ['required' => true])
            ->add('root_category', NumberType::class, ['required' => true])
            ->add('description', TextareaType::class, ['required' => false])
            ->add('meta_title', TextType::class, ['required' => false
                ,'constraints' => [new LengthConstraint(5,255)]])
            ->add('meta_keyword', TextType::class, ['required' => false,'constraints' => [new LengthConstraint(5,255)]])
            ->add('meta_description', TextareaType::class, ['required' => false])
            ->add('image_url', TextType::class, ['required' => false,'constraints' => [new LengthConstraint(5,255)]])
            ->add('code', NumberType::class, ['required' => true])
            ->add('url_rewritten', TextType::class, ['required' => true,'constraints' => [new LengthConstraint(5,255)]])
            ->add('submit', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
