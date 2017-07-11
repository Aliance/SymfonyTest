<?php

namespace AppBundle\Form;

use AppBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Optional;

class UserType extends AbstractType
{
    /** @inheritdoc */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('modifier', TextType::class, [
                'constraints' => [
                    new NotBlank(['groups' => ['modify']]),
                ],
            ])
            ->add(
                $builder
                    ->create('info', FormType::class, ['by_reference' => true])
                    ->add('id', TextType::class)
                    ->add('title', TextType::class, [
                        'constraints' => [
                            new NotBlank(['groups' => ['info']]),
                        ],
                    ])
                    ->add('text', TextType::class, [
                        'constraints' => [
                            new Optional(),
//                            new NotBlank(),
                        ],
                    ])
            )
        ;
    }

    /** @inheritdoc */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'csrf_protection' => false,
        ]);
    }
}
