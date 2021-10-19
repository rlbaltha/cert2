<?php

namespace App\Form;

use App\Entity\Checklist;
use App\Entity\Course;
use App\Repository\CourseRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChecklistType extends AbstractType
{
    private $courseRepository;
    public function __construct(CourseRepository $courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }
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
                'choices' => $this->courseRepository->findForChecklist('Anchor'),
                'choice_label' => 'name',
                'choice_value' => 'id',
                'label'  => 'Anchor Course',
                'expanded' => false,
                'required' => false,
            ])
            ->add('seminar', EntityType::class, [
                'class' => Course::class,
                'choices' => $this->courseRepository->findBy(['sphere'=>'Seminar'], ['name' => 'ASC']),
                'choice_label' => 'name',
                'choice_value' => 'id',
                'label'  => 'Seminar',
                'expanded' => false,
                'required' => false,
            ])
            ->add('sphere1', EntityType::class, [
                'class' => Course::class,
                'choices' => $this->courseRepository->findForChecklist('Social'),
                'choice_label' => 'name',
                'choice_value' => 'id',
                'label'  => 'Social Sphere',
                'expanded' => false,
                'required' => false,
            ])
            ->add('sphere2', EntityType::class, [
                'class' => Course::class,
                'choices' => $this->courseRepository->findForChecklist('Economic'),
                'choice_label' => 'name',
                'choice_value' => 'id',
                'label'  => 'Economic Sphere',
                'expanded' => false,
                'required' => false,
            ])
            ->add('sphere3', EntityType::class, [
                'class' => Course::class,
                'choices' => $this->courseRepository->findForChecklist('Ecological'),
                'choice_label' => 'name',
                'choice_value' => 'id',
                'label'  => 'Ecological Sphere',
                'expanded' => false,
                'required' => false,
            ])
            ->add('capstone', EntityType::class, [
                'class' => Course::class,
                'choices' => $this->courseRepository->findForChecklist('Capstone'),
                'choice_label' => 'name',
                'choice_value' => 'id',
                'label'  => 'Capstone',
                'expanded' => false,
                'required' => false,
            ])
            ->add('presentation', ChoiceType::class, [
                'label' => 'Where did you present your capstone?',
                'choices'  => [
                    'Seminar' => 'Seminar',
                    'Semester in Review' => 'Semester in Review',
                    'Conference' => 'Conference',
                ],
                'required' => false,
            ])
            ->add('appliedtograd', ChoiceType::class, [
                'label' => 'Have you applied to graduate with the Certificate in Athena?',
                'choices'  => [
                    'Yes' => 'Yes',
                    'No' => 'No',
                ],
                'required' => false,
            ])
            ->add('athena', DateType::class, [
                'label' => 'Date Certificate was added in Athena',
                'required' => false,
            ])
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
