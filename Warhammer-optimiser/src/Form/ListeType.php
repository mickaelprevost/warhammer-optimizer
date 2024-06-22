<?php

namespace App\Form;

use App\Entity\Items;
use App\Entity\Renownabilities;
use App\Entity\Template;
use App\Entity\TemplateListe;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ListeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('template', EntityType::class, [
                'class' => Template::class,
                'choice_label' => 'id',
            ])
            ->add('items', EntityType::class, [
                'class' => Items::class,
                'choice_label' => 'id',
            ])
            ->add('renownabilities', EntityType::class, [
                'class' => Renownabilities::class,
                'choice_label' => 'name',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TemplateListe::class,
        ]);
    }
}
