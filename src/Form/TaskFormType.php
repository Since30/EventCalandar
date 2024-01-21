<?php

namespace App\Form;

use App\Entity\Task;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaskFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('title')
        ->add('start', DateType::class, [
            'widget' => 'single_text', // Assurez-vous d'utiliser le widget 'single_text' pour le type de date
            'attr' => ['min' => (new \DateTime())->format('Y-m-d')], // Définit la date d'aujourd'hui comme date minimale
        ])
        ->add('end', DateType::class, [
            'widget' => 'single_text',
            'attr' => ['min' => '2024-01-01'], // Définit une date minimale spécifique
        ])
        ->add('user', EntityType::class, [
            'class' => User::class,
            'choice_label' => 'email',
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
        ]);
    }
}
