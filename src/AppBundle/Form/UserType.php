<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Entity\User;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('forename')
            ->add('surname')
            ->add('isActive', null, ['required' => false])
            ->add('isAdmin', CheckboxType::class, ['required' => false])
            ->add('plainPassword', null, ['required' => !$options['update']])
            ->add('mondayIn', TimeType::class, ['hours' => User::SCHEDULE_HOURS, 'minutes' => User::SCHEDULE_MINUTES])
            ->add('mondayOut', TimeType::class, ['hours' => User::SCHEDULE_HOURS, 'minutes' => User::SCHEDULE_MINUTES])
            ->add('tuesdayIn', TimeType::class, ['hours' => User::SCHEDULE_HOURS, 'minutes' => User::SCHEDULE_MINUTES])
            ->add('tuesdayOut', TimeType::class, ['hours' => User::SCHEDULE_HOURS, 'minutes' => User::SCHEDULE_MINUTES])
            ->add('wednesdayIn', TimeType::class, ['hours' => User::SCHEDULE_HOURS, 'minutes' => User::SCHEDULE_MINUTES])
            ->add('wednesdayOut', TimeType::class, ['hours' => User::SCHEDULE_HOURS, 'minutes' => User::SCHEDULE_MINUTES])
            ->add('thursdayIn', TimeType::class, ['hours' => User::SCHEDULE_HOURS, 'minutes' => User::SCHEDULE_MINUTES])
            ->add('thursdayOut', TimeType::class, ['hours' => User::SCHEDULE_HOURS, 'minutes' => User::SCHEDULE_MINUTES])
            ->add('fridayIn', TimeType::class, ['hours' => User::SCHEDULE_HOURS, 'minutes' => User::SCHEDULE_MINUTES])
            ->add('fridayOut', TimeType::class, ['hours' => User::SCHEDULE_HOURS, 'minutes' => User::SCHEDULE_MINUTES])
            ->add('newUserBtn', SubmitType::class, ['label' => $options['submitLabel'], 'attr' => ['class' => 'btn btn-lg btn-success btn-block']])
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class'            => 'AppBundle\Entity\User',
                'update'                => false,
                'submitLabel'           => 'New user',
                'validation_groups'     => function (FormInterface $form) {
                    $data = $form->getData();

                    if ($data->getPlainPassword() == '' && $form->getConfig()->getOption('update')) {
                        return ['Default'];
                    }

                    return ['Default', 'Update'];
                },
            ]
        );
    }

    public function getName()
    {
        return 'app_bundle_user_type';
    }
}
