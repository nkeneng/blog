<?php

namespace App\Form;

use App\Entity\ArticlesSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticlesSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
//            ->add('user', TextType::class, array(
//                'required' => false,
//                'label_attr' => array('class' => 'sr-only'),
//                'label' => 'Auteur',
//                'attr' => [
//                    'class' => 'form-control border-postul',
//                    'placeholder' => 'Entrez l\'auteur'
//                ]))
            ->add('category', TextType::class, array(
                'required' => false,
                'label_attr' => array('class' => 'sr-only'),
                'label' => 'Category',
                'attr' => [
                    'class' => 'form-control input-sm',
                    'placeholder' => 'entrez votre categorie'
                ]));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ArticlesSearch::class,
        ]);
    }
}
