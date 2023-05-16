<?php

namespace App\Form;

use App\Entity\Category;
use App\Form\Constraints\LengthConstraint;
use App\Repository\CategoryRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryType extends AbstractType
{
    private CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        //get all Category to do choice list
        $qb = $this->categoryRepository->createQueryBuilder('cat')->select('cat.id', 'cat.name');
        $query = $qb->getQuery();
        $categories = $query->execute();

        $choiceList = [];
        foreach ($categories as $category) {
            $choiceList[$category['name']] = ['id' => $category['id']];
        }

        $builder
            ->add('is_active', CheckboxType::class, ['required' => false])
            ->add('name', TextType::class, [
                    'required' => true,
                    'constraints' => [new LengthConstraint(5, 255),],
                ]
            )
            ->add('id_parent', EntityType::class, [
                'class'=> Category::class,
                'choice_label' => 'name',
                'mapped' => false,
                'data' => $this->categoryRepository->find($builder->getData()->getIdParent())

            ])
            ->add('root_category', NumberType::class, ['required' => true])
            ->add('description', TextareaType::class, ['required' => false])
            ->add('meta_title', TextType::class, [
                'required' => false
                , 'constraints' => [new LengthConstraint(5, 255)],
            ])
            ->add('meta_keyword', TextType::class,
                ['required' => false, 'constraints' => [new LengthConstraint(5, 255)]])
            ->add('meta_description', TextareaType::class, ['required' => false])
            ->add('image_url', TextType::class, ['required' => false, 'constraints' => [new LengthConstraint(5, 255)]])
            ->add('code', NumberType::class, ['required' => true])
            ->add('url_rewritten', TextType::class,
                ['required' => true, 'constraints' => [new LengthConstraint(5, 255)]])
            ->add('submit', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
