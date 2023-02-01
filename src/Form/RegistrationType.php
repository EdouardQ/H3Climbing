<?php

namespace App\Form;

use App\Entity\Registration;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $form = $event->getForm();
            /** @var Registration $registration */
            $registration = $event->getData();

            if ($registration->getPresence() === null) {
                $form->add('presence', ChoiceType::class, [
                    'label' => $registration->getUser()->getFullName(),
                    'choices' => [
                        'Present' => true,
                        'Absent' => false,
                        'Do not know' => null,
                    ]
                ]);
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Registration::class,
        ]);
    }
}