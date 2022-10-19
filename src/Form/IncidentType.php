<?php

namespace App\Form;

use App\Entity\Incident;
use App\Entity\Level;
use App\Entity\Type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class IncidentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            //->add('createdAt')
            ->add('reporterEmail',EmailType::class,[
                "required"=>false,
                'label'=>'Email'
            ])
            ->add('description',TextareaType::class,[
                "required"=>false
            ])
            ->add('level', EntityType::class, [
                'class' => Level::class,
                'choice_label' => function ($level) {
                    return $level->getLabel();
                },
                'label'=>'Priorité'
            ])
            ->add('types', EntityType::class, [
                'class' => Type::class,
                'choice_label' => function ($type) {
                    return $type->getLabel();
                },
                'label_attr' => [
                    'class' => 'checkbox-inline',
                ],
                'multiple' => true,
                'expanded' => true,
                'by_reference' => false
            ])
            //->add('reference')
            //->add('processedAt')
            //->add('resolveAt')
            //->add('rejectedAt')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Incident::class,
        ]);
    }
}
