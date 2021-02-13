<?php

namespace App\Form;

use App\Entity\Application;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ApplicationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ugaid', TextType::class, [
                'label' => 'UGA ID ',
                'attr' => [
                    'placeholder' => '811000000']
            ])
            ->add('level', ChoiceType::class, [
                'choices'  => [
                    'Undergrad' => 'Undergrad',
                    'Grad' => 'Grad'
                ],
                'expanded'=> true,
            ])
            ->add('interest')
            ->add('experience')
            ->add('goals')
            ->add('status', ChoiceType::class, [
                'choices'  => [
                    'Still Editing' => 'Still Editing',
                    'Ready for Review' => 'Ready for Review'
                ],
                'expanded'=> true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Application::class,
        ]);
    }
}
