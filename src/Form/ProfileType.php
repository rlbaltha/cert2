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
            ->add('gradyear', EntityType::class, [
                'class' => Year::class,
                'choices' => $this->yearRepository->findBy(['display'=>'Current'], ['year' => 'DESC']),
                'choice_label' => 'year',
                'choice_value' => 'year',
                'label'  => 'Graduation Year',
                'expanded' => false,
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
