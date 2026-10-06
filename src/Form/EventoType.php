<?php

namespace App\Form;

use App\Entity\Evento;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TimeType;


class EventoType extends AbstractType
{
    public function buildForm(
        FormBuilderInterface $builder,
        array $options
    ): void {
        $builder
            ->add('titulo', null, [
        'label' => 'Nombre del evento',
        'attr' => [
            'placeholder' => 'Ingrese el nombre del evento',
        ],
    ])
            ->add('descripcion', null, [
        'label' => 'Descripción',
        'attr' => [
            'placeholder' => 'Ingrese una descripción',
        ],
    ])
            ->add('fecha', null, [
        'label' => 'Fecha del evento',
    ])
            ->add('hora', null, [
        'label' => 'Hora del evento',
    ]);
    }

    public function configureOptions(
        OptionsResolver $resolver
    ): void {
        $resolver->setDefaults([
            'data_class' => Evento::class
        ]);
    }
}
