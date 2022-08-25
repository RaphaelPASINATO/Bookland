<?php

namespace App\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateType;


class SelectionLivreAnneeNote extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
           
           ->add('dateMinSelect', DateType::class, [
            'label' => 'date minimum','widget' => 'choice', 'years' => range(date('Y'), date('Y')-100)
           ])
            ->add('dateMaxSelect', DateType::class, [
            'label' => 'date maximum', 'years' => range(date('Y'), date('Y')-100)
            ])
            ->add('noteMin', IntegerType::class, [
                'label' => 'note minimun','attr' => ['min' => 0,'max' => 20]
            ])
            ->add('noteMax', IntegerType::class, [
                'label' => 'note maximum', 'attr' => ['min' => 0,'max' => 20]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
        ]);
    }
}
