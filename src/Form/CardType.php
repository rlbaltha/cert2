<?php

namespace App\Form;

use App\Entity\Card;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CardType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('application', TextType::class, [
                'label' => 'Application (i.e. where the app uses the test; please do not edit)',
            ])
            ->add('title', TextType::class, [
                'label' => 'Title (Subject)',
            ])
            ->add('body', CKEditorType::class, [
                'config_name' => 'editor_simple',
                'label' => 'Body (Email Content)',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Card::class,
        ]);
    }
}
