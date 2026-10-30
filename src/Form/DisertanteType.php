<?php

namespace App\Form;

use App\Entity\Disertante;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DisertanteType extends AbstractType
{
    public function buildForm(
        FormBuilderInterface $builder,
        array $options
    ): void {
        $builder
            // --- Datos personales ---
            ->add('nombre', TextType::class, [
                'label' => 'Nombre',
                'attr' => ['placeholder' => 'Ingrese el nombre'],
            ])
            ->add('apellido', TextType::class, [
                'label' => 'Apellido',
                'attr' => ['placeholder' => 'Ingrese el apellido'],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'attr' => ['placeholder' => 'correo@ejemplo.com'],
            ])
            ->add('telefono', TextType::class, [
                'label' => 'Teléfono',
                'required' => false,
                'attr' => ['placeholder' => 'Ej: +54 11 1234-5678'],
            ])
            ->add('especialidad', TextType::class, [
                'label' => 'Especialidad',
                'attr' => ['placeholder' => 'Ej: Desarrollo Web'],
            ])

            // --- Enlaces y redes ---
            ->add('url', UrlType::class, [
                'label' => 'Sitio web',
                'required' => false,
                'attr' => ['placeholder' => 'https://ejemplo.com'],
            ])
            ->add('twitter', TextType::class, [
                'label' => 'Twitter / X',
                'required' => false,
                'attr' => ['placeholder' => '@usuario'],
            ])
            ->add('linkedin', UrlType::class, [
                'label' => 'LinkedIn',
                'required' => false,
                'attr' => ['placeholder' => 'https://linkedin.com/in/usuario'],
            ])

            // --- Biografía ---
            ->add('biografia', TextareaType::class, [
                'label' => 'Biografía',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Breve descripción del disertante...',
                    'rows' => 5,
                ],
            ]);
    }

    public function configureOptions(
        OptionsResolver $resolver
    ): void {
        $resolver->setDefaults([
            'data_class' => Disertante::class,
        ]);
    }
}