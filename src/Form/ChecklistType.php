<?php

namespace App\Form;

use App\Entity\Checklist;
use App\Entity\Course;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChecklistType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pre_assess', DateType::class, [
                'label' => 'Date you completed your pre-certificate survey',
                'required' => false,
            ])
            ->add('orientation', DateType::class, [
                'label' => 'Date you completed your orientation',
                'required' => false,
            ])
            ->add('anchor', EntityType::class, [
                'class' => Course::class,
                'choice_label' => 'name',
                'choice_value' => 'id',
                'label'  => 'Anchor Course',
                'expanded' => false,
                'required' => false,
            ])
            ->add('seminar', EntityType::class, [
                'class' => Course::class,
                'choice_label' => 'name',
                'choice_value' => 'id',
                'label'  => 'Seminar',
                'expanded' => false,
                'required' => false,
            ])
            ->add('sphere1', EntityType::class, [
                'class' => Course::class,
                'choice_label' => 'name',
                'choice_value' => 'id',
                'label'  => 'Sphere 1',
                'expanded' => false,
                'required' => false,
            ])
            ->add('sphere2', EntityType::class, [
                'class' => Course::class,
                'choice_label' => 'name',
                'choice_value' => 'id',
                'label'  => 'Sphere 2',
                'expanded' => false,
                'required' => false,
            ])
            ->add('sphere3', EntityType::class, [
                'class' => Course::class,
                'choice_label' => 'name',
                'choice_value' => 'id',
                'label'  => 'Sphere 3',
                'expanded' => false,
                'required' => false,
            ])
            ->add('capstone', EntityType::class, [
                'class' => Course::class,
                'choice_label' => 'name',
                'choice_value' => 'id',
                'label'  => 'Capstone',
                'expanded' => false,
                'required' => false,
            ])
            ->add('presentation')
            ->add('appliedtograd')
            ->add('athena')
            ->add('post_assess', DateType::class, [
                'label' => 'Date you completed your post-certificate assessment',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Checklist::class,
        ]);
    }
}
