<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
            ->add('mondayIn', TimeType::class, ['hours' => [8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21], 'minutes' => [0, 20, 30, 50]])
            ->add('mondayOut', TimeType::class, ['hours' => [8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21], 'minutes' => [0, 20, 30, 50]])
            ->add('tuesdayIn', TimeType::class, ['hours' => [8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21], 'minutes' => [0, 20, 30, 50]])
            ->add('tuesdayOut', TimeType::class, ['hours' => [8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21], 'minutes' => [0, 20, 30, 50]])
            ->add('wednesdayIn', TimeType::class, ['hours' => [8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21], 'minutes' => [0, 20, 30, 50]])
            ->add('wednesdayOut', TimeType::class, ['hours' => [8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21], 'minutes' => [0, 20, 30, 50]])
            ->add('thursdayIn', TimeType::class, ['hours' => [8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21], 'minutes' => [0, 20, 30, 50]])
            ->add('thursdayOut', TimeType::class, ['hours' => [8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21], 'minutes' => [0, 20, 30, 50]])
            ->add('fridayIn', TimeType::class, ['hours' => [8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21], 'minutes' => [0, 20, 30, 50]])
            ->add('fridayOut', TimeType::class, ['hours' => [8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21], 'minutes' => [0, 20, 30, 50]])
            ->add('newUserBtn', SubmitType::class, ['label' => $options['submitLabel'], 'attr' => ['class' => 'btn btn-lg btn-success btn-block']])
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class'            => 'AppBundle\Entity\User',
                'update'                => true,
                'submitLabel'           => 'New user',
                'validation_groups'     => function (FormInterface $form) {
                    $data = $form->getData();

                    if ($data->getPlainPassword() == '') {
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
