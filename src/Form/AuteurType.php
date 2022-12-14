<?php

namespace App\Form;

use App\Entity\Auteur;
use App\Entity\Livre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class AuteurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom_prenom')
            ->add('sexe',ChoiceType::class,
            array('choices' => array(
                    'Homme' => 'M',
                    'Femme' => 'F')))
	    ->add('date_de_naissance', DateType::class, [
                'required' => true,
                'widget' => 'choice', 'years' => range(date('Y'), date('Y')-100)
            ])
            ->add('nationalite')
	    ->add('livre_ecrit',EntityType::class,['class' => Livre::class,'choice_label' => 'titre','multiple' => true, 'required' => false]);
		
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Auteur::class,
        ]);
    }
}
