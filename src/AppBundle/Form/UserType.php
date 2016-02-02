<?php

namespace AppBundle\Form;

use AppBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class UserType extends AbstractType
{
    private $token_user;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $userData = $builder->getData();
        $this->token_user = $options['token_user'];

        $builder
            ->add(
                'nick',
                TextType::class,
                [
                    'label' => 'Escribe un nick:',
                    'attr' => [
                        'readonly' => ($userData->getId() ? true : false),
                    ],
                ]
            )
            ->add(
                'message',
                TextareaType::class,
                [
                    'label' => 'Escribe un mensaje:',
                    'attr' => [
                        'readonly' => ($userData->getId() ? true : false),
                    ],
                ]
            );

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) {
                $form = $event->getForm();
                $user = $event->getData();

                if ($this->token_user) {
                    $form
                        ->add(
                            'publishedAt',
                            DateType::class
                        );
                }

                if (!$user->getAvatar()) {
                    $form
                        ->add(
                            'file',
                            FileType::class,
                            [
                                'label' => 'Subir un avatar o cualquier archivo',
                                'required' => false,
                            ]
                        );
                }
            }
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => User::class,
                'token_user' => null,
            )
        );
    }
}
