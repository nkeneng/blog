<?php

namespace App\Form;

use App\Entity\Articles;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array(
                'required' => true,
                'label_attr' => array('class' => 'text-info'),
                'label' => 'Your title',
                'attr' => [
                    'class' => 'form-control border-postul',
                    'placeholder' => 'Title'
                ]))
            ->add('content', TextareaType::class, array(
                'required' => true,
                'label_attr' => array('class' => 'text-info'),
                'label' => 'Text',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Insert article text'
                ]))
//            ->add('image')
//            ->add('filename')
            ->add('category', EntityType::class, [
                'label_attr' => array('class' => 'text-info'),
                'class' => Category::class,
                'choice_label' => 'name',
                'placeholder' => "Choose one option",
                'attr' => [
                    'class' => 'form-control'
                ],])
            ->add('imageFile',FileType::class,[
                'label_attr' => array('class' => 'custom-file-label'),
                'required'=>false,
                'attr' => [
                    'class' => 'custom-file-input',
                    'placeholder' => "Choose file",],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Articles::class,
        ]);
    }
}
