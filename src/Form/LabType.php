<?php

namespace App\Form;

use App\Entity\Lab;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LabType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('html')
            ->add('css')
            ->add('js')
//            ->add('php')
            ->add('hasJquery')
            ->add('hasFontawesome')
            ->add('hasBootstrap')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Lab::class,
        ]);
    }
}
