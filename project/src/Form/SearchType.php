<?php

namespace App\Form;

use App\Model\SearchData;
use App\Entity\Post\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('q', TextType::class, [
                'attr' => [
                    'placeholder' => 'Recherche via mot clé....'
                ],
                'empty_data' => "",
                'required' => false
            ])
            ->add('categories', EntityType::class, [
                'class' => Category::class, // Avec EntityType on va faire référence ici a la class Category (entity category)
                'expanded' => true,
                'multiple' => true
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SearchData::class, // On fait référence a la class App\Model\SearchData
            'method' => 'GET',
            'csrf_protection' => false
        ]);
    }

}