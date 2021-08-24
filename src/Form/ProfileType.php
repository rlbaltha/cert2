<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Year;
use App\Repository\YearRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfileType extends AbstractType
{
    private $yearRepository;
    public function __construct(YearRepository $yearRepository)
    {
        $this->yearRepository = $yearRepository;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => 'First Name'
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Last Name'
            ])
            ->add('altemail', TextType::class, [
                'label' => 'Alternative Email',
                'attr' => [
                    'placeholder' => 'ima@gmail.com'],
                'required' => false,
            ])
            ->add('gradterm', ChoiceType::class, [
                'choices'  => [
                    'Fall' => 'Fall',
                    'Spring' => 'Spring'
                ],
                'expanded'=> false,
                'label'  => 'Graduation Term',
                'required' => false,
            ])
            ->add('gradyear', TextType::class, [
                'label' => 'Graduation Year e.g. 2022',
                'required' => false,
            ])
            ->add('school1', EntityType::class, array('required' => false,'class' => 'App\Entity\School',
                'choice_label' => 'name','expanded'=>false,'multiple'=>false,'label'  => 'School', 'attr' => array('class' =>
                    'form-control'),))
            ->add('major1', EntityType::class, array('required' => false,'class' => 'App\Entity\Major',
                'choice_label' => 'name','expanded'=>false,'multiple'=>false,'label'  => 'Major', 'attr' => array('class' =>
                    'form-control'),))
            ->add('school2', EntityType::class, array('required' => false,'class' => 'App\Entity\School',
                'choice_label' => 'name','expanded'=>false,'multiple'=>false,'label'  => 'School of Second Major', 'attr' => array('class' =>
                    'form-control'),))
            ->add('major2', EntityType::class, array('required' => false,'class' => 'App\Entity\Major',
                'choice_label' => 'name','expanded'=>false,'multiple'=>false,'label'  => 'Second Major', 'attr' => array('class' =>
                    'form-control'),))
            ->add('minors', TextType::class, [
                'label' => 'Minors',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
