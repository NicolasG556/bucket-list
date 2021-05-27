<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Wish;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use function Sodium\add;

class WishType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',TextType::class,
                ['label' => 'Title of wish',
                    'required' => true
            ])
            ->add('description', TextareaType::class,
                [
                    'label' => 'Description'
                ])
            ->add('author', TextType::class)

            ->add('note')
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name'
    ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Wish::class,
        ]);
    }
}
