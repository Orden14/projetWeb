<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'title', TextType::class, [
                    'mapped' => false
                ])
            ->add('description', TextType::class, [
                'mapped' => false
            ])
            ->add('body', TextareaType::class, [
                'mapped' => false
            ])
            ->add('save', SubmitType::class, ['label' => 'Create Article']);
    }
}