<?php

namespace App\Form;

use App\Entity\Disertante;
use App\Entity\Evento;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventoType extends AbstractType
{
    public function buildForm(
        FormBuilderInterface $builder,
        array $options
    ): void {
        $builder
            ->add('titulo', TextType::class, [
                'label' => 'Nombre del evento',
                'attr' => [
                    'placeholder' => 'Ingrese el nombre del evento',
                ],
            ])
            ->add('descripcion', TextareaType::class, [
                'label' => 'Descripción',
                'attr' => [
                    'placeholder' => 'Ingrese una descripción',
                    'rows' => 4,
                ],
            ])
            ->add('fecha', DateType::class, [
                'label' => 'Fecha del evento',
                'widget' => 'single_text',
            ])
            ->add('hora', TimeType::class, [
                'label' => 'Hora del evento',
                'widget' => 'single_text',
            ])
            ->add('duracion', IntegerType::class, [
                'label' => 'Duración (en minutos)',
                'attr' => [
                    'placeholder' => 'Ej: 90',
                    'min' => 1,
                ],
            ])
            ->add('idioma', ChoiceType::class, [
                'label' => 'Idioma',
                'choices' => [
                    'Español'   => 'Español',
                    'Inglés'    => 'Inglés',
                    'Portugués' => 'Portugués',
                ],
                'placeholder' => '— Seleccione un idioma —',
            ])
            ->add('disertante', EntityType::class, [
                'class' => Disertante::class,
                'label' => 'Disertante',
                'required' => false,
                'placeholder' => '— Sin disertante —',
                'choice_label' => function (?Disertante $d) {
                    return $d ? (string) $d : '';
                },
            ])
            ->add('capacidad', IntegerType::class, [
                'label' => 'Capacidad',
                'required' => false,
                'empty_data' => '0',
                'attr' => [
                    'min' => 0,
                ],
            ])
            ->add('estado', ChoiceType::class, [
                'label' => 'Estado',
                'choices' => [
                    'Activo'     => 'activo',
                    'Cancelado'  => 'cancelado',
                    'Finalizado' => 'finalizado',
                ],
            ]);
    }

    public function configureOptions(
        OptionsResolver $resolver
    ): void {
        $resolver->setDefaults([
            'data_class' => Evento::class,
        ]);
    }
}