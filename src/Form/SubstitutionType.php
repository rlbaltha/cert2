<?php

namespace App\Form;

use App\Entity\Substitution;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SubstitutionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('requirement', ChoiceType::class, [
                'choices'  => [
                    'Anchor' => 'Anchor',
                    'Seminar' => 'Seminar',
                    'Social Sphere' => 'Social Sphere',
                    'Economic Sphere' => 'Economic Sphere',
                    'Ecological Sphere' => 'Ecological Sphere',
                    'Capstone' => 'Capstone',
                ],
                'expanded'=> true,
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Please explain how this substitution meets the requirement.',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Substitution::class,
        ]);
    }
}
