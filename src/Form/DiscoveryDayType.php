<?php

namespace App\Form;

use App\Entity\Rank;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\NotBlank;

class DiscoveryDayType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a title',
                    ])
                ]
            ])
            ->add('minimumRank', EntityType::class, [
                'class' => Rank::class,
                'choice_label' => 'name',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please select a minimum rank',
                    ])
                ]
            ])
            ->add('date', DateTimeType::class, [
                'widget' => 'single_text',
                'empty_data' => '',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a date',
                    ]),
                    new GreaterThan([
                        'value' => 'now',
                        'message' => 'The date must be in the future',
                    ])
                ]
            ])
            ->add('maxParticipant', IntegerType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a max participant number',
                    ]),
                    new GreaterThan([
                        'value' => 0,
                        'message' => 'The max participant number must be greater than 0',
                    ])
                ]
            ])
            ->add('location', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a location',
                    ])
                ]
            ])
        ;
    }
}
