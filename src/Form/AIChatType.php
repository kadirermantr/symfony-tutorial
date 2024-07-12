<?php

namespace App\Form;

use App\Enum\AIModelEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;

class AIChatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('prompt', TextareaType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form-control',
                    'autofocus' => true,
                ]
            ])
            ->add('model', EnumType::class, [
                'class' => AIModelEnum::class,
                'label' => 'Select Model',
                'attr' => [
                    'class' => 'form-select',
                ],
                'choice_label' => fn($choice) => $choice->value,
            ])
            ->add('send', SubmitType::class, [
				'attr' => [
					'class' => 'btn btn-primary float-end'
				]
			])
        ;
    }
}
