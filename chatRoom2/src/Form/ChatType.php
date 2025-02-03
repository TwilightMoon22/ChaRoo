<?php

namespace App\Form;

use App\Entity\Chat;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ChatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // Campo de nombre para el chat
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nombre del Chat', // Etiqueta visible para el campo
                'attr' => [
                    'placeholder' => 'Ingresa el nombre del chat', // Placeholder que aparece como texto de ayuda
                    'class' => 'form-control' // Clase CSS para darle estilo
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Chat::class, // Asegura que los datos del formulario se asignen a la entidad Chat
        ]);
    }
}
