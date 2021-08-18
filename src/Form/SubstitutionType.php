<?php

namespace App\Form;

use App\Entity\Substitution;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
            ->add('description', CKEditorType::class, [
                'config_name' => 'editor_simple',
                'label' => 'What is your interest in Sustainability',
            ])
            ->add('status', ChoiceType::class, [
                'choices'  => [
                    'Created' => 'Created',
                    'Approved' => 'Approved',
                    'Denied' => 'Denied',
                ],
                'expanded'=> true,
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
