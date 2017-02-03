<?php

namespace AppBundle\Form;

use AppBundle\Entity\Attendance;
use Symfony\Component\Form\AbstractType;
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
