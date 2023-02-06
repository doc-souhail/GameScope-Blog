<?php

namespace App\Form;

use App\Entity\ArticleKind;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ArticleSearchForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // Modifie la méthode du formulaire
            ->setMethod('GET')
            // Ajoute les champs souhaités au formulaire de recherche
            ->add('title', TextType::class, [
                'attr' => [
                    'placeholder' => 'Search',
                    'class' => 'search-input'
                ],
                'label' => false,
                'required' => false
            ]);
//            ->add('save', SubmitType::class, [
//                'attr' => [
//                    'class' => 'btn btn-success'
//                ],
//                'label' => 'go'
//            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
        ]);
    }
}