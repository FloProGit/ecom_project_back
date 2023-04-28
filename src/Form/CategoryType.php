<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Validator\Constraints as Assert;

class CategoryType extends AbstractType
{

    private const TextType = [
        'attr'=>[
            'class'=>'',
            'minlenght'=>2,
            'maxlenght'=>255,
        ],
        'label'=> 'is active',
        'label_attr'=>[
            'class' => ''
        ],
    ];
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('is_active',CheckboxType::class)
            ->add('name',TextType::class,self::TextType)
            ->add('id_parent',NumberType::class)
            ->add('parent',TextType::class)
            ->add('root_category',NumberType::class)
            ->add('description',TextareaType::class)
            ->add('meta_title',TextType::class)
            ->add('meta_keyword',TextType::class)
            ->add('meta_description',TextareaType::class)
            ->add('image_url',TextType::class)
            ->add('code',NumberType::class)
            ->add('url_rewritten',TextType::class)
            ->add('submit',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
