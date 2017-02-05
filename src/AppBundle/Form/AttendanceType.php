<?php

namespace AppBundle\Form;

use AppBundle\Entity\Attendance;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AttendanceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('justified')
            ->add('commentByUser')
            ->add('commentByAdmin')
            ->add('entradaBtn', SubmitType::class, ['label' => 'Entrada', 'attr' => ['class' => 'btn btn-lg btn-warning btn-block', 'style' => 'margin-bottom: 5px;']])
            ->add('sortidaBtn', SubmitType::class, ['label' => 'Sortida', 'attr' => ['class' => 'btn btn-lg btn-success btn-block','style' => 'margin-bottom: 5px;']])
            ->add('absenciaBtn', SubmitType::class, ['label' => 'Absència', 'attr' => ['class' => 'btn btn-lg btn-danger btn-block']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Attendance::class,
        ));
    }

    public function getName()
    {
        return 'app_bundle_attendance_type';
    }
}
