<?php

namespace App\Form;

use App\Entity\ArticleKind;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Count;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Regex;


class ArticlesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'attr' => [
                    'class' => 'input-crud'
                ]
            ])
            ->add('kinds', EntityType::class, [
                'attr' => [
                    'class' => 'input-crud'
                ],
                'label' => 'Article Type',
                'multiple' => true,
                'expanded' => true,
                'class' => ArticleKind::class,
                'constraints' => [
                    new Count([
                        'min' => 1,
                        'max' => 3,
                    ])
                ]
            ])
            ->add('coverImageFile', VichImageType::class, [
                'required' => false,
                'attr' => [
                    'class' => 'image-crud edit-image image_input'
                ],
                'constraints' => [
                    new File([
//                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpeg',

                        ],
                        'mimeTypesMessage' => 'Please upload a valid document',
                    ])
                ]
            ])
            ->add('text', TextareaType::class, [
                'attr' => [
                    'class' => 'unput-crud'
                ],
            ])
            ->add('save', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-success btn'
                ]
            ]);
    }
}
