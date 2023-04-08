<?php

namespace App\Form;

use App\Entity\Video;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotNull;

class VideoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomvid')
            ->add('url', FileType::class, [
                'label' => 'url',
                'mapped' => false, // do not map this field to the entity property
                'required' => true, // make the field required
                'constraints' => [
                    new File([
                        'mimeTypes' => [
                            'video/*',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid video file',
                    ])
                ],
            ])
            ->add('idest', null, [
                'data' => $options['current_idest'],
                'disabled' => false,
                'constraints' => [
                    new NotNull([
                        'message' => 'Please select an option',
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Video::class,
            'current_idest' => null,
        ]);
    }
}