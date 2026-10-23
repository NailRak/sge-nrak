<?php

namespace App\Form;

use App\Entity\Disertante;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DisertanteType extends AbstractType
{
    public function buildForm(
        FormBuilderInterface $builder,
        array $options
    ): void {
        $builder
            ->add('nombre', null, [
        'label' => 'Nombre del disertante',
        'attr' => [
            'placeholder' => 'Ingrese el nombre...',
        ],
    ])
            ->add('apellido', null, [
        'label' => 'Apellido',
        'attr' => [
            'placeholder' => 'Ingrese el apellido...',
        ],
    ])
          ->add('email', null, [
        'label' => 'Email',
        'attr' => [
            'placeholder' => 'Ingrese el email...',
        ],
    ])
    ->add('especialidad', null, [
        'label' => 'Especialidad',
        'attr' => [
            'placeholder' => 'Ingrese la especialidad...',
        ],
    ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Disertante::class,
        ]);
    }
}
