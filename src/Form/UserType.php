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

class UserType extends AbstractType
{
    private $yearRepository;
    public function __construct(YearRepository $yearRepository)
    {
        $this->yearRepository = $yearRepository;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName')
            ->add('lastName')
            ->add('roles', ChoiceType::class, [
                'choices'  => [
                    'ROLE_USER' => 'ROLE_USER',
                    'ROLE_ADMIN' => 'ROLE_ADMIN',
                    'ROLE_ALLOWED_TO_SWITCH' => 'ROLE_ALLOWED_TO_SWITCH',
                ],
                'expanded' => true,
                'multiple' => true,
            ])
            ->add('email')
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
                'label' => 'Year you expect to graduate',
                'attr' => [
                    'placeholder' => '2024'],
                'required' => false,
            ])
            ->add('progress', ChoiceType::class, [
                'choices'  => [
                    'Application' => 'Application',
                    'Checklist' => 'Checklist',
                    'Graduating' => 'Graduating',
                    'Alumni' => 'Alumni',
                    'Admin' => 'Admin',
                    'Inactive' => 'Inactive',
                ],
                'expanded'=> false,
                'label'  => 'Progress',
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
