<?php

namespace App\Form;

use App\Entity\Course;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CourseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('title')
            ->add('sphere', ChoiceType::class, array('choices' => array('Anchor' => 'Anchor','Seminar' => 'Seminar','Social' => 'Social', 'Economic'
            => 'Economic', 'Ecological' => 'Ecological', 'Capstone' => 'Capstone', 'Anchor or Any Pillar' => 'Any'),
                'required' =>  true,
                'expanded' => true,
                'multiple' => false,
                'label' => 'Pillar',
                'attr' => array('class' => 'radio'),))
            ->add('level', ChoiceType::class, array('choices' => array('Grad' => 'Grad', 'Undergrad' => 'Undergrad', 'Split' => 'Split'), 'required' =>
                true,
                'expanded' => true, 'multiple' => false, 'label' => 'Level',
                'attr' => array('class' => 'radio'),))
            ->add('status', ChoiceType::class, array('choices' => array('Approved' => 'Approved', 'Substitution' => 'Substitution'), 'required' =>
                true,
                'expanded' => true, 'multiple' => false, 'label' => 'Status',
                'attr' => array('class' => 'radio'),))
            ->add('school', EntityType::class, array('required' => true,'class' => 'App\Entity\School',
                'choice_label' => 'name','expanded'=>false,'multiple'=>false,'label'  => 'School/College', 'attr' => array('class' =>
                    'form-control'),))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Course::class,
        ]);
    }
}
