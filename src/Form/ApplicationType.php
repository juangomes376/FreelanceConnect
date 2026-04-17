<?php

namespace App\Form;

use App\Entity\Application;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ApplicationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('coverLetter')
            // CV upload pdf input type with validation for pdf files only
            ->add('cvFilename', FileType::class, [
                'label' => 'CV',
                'mapped' => false,
                'required' => false,
                'attr' => [
                    'accept' => '.pdf',
                ],
                'constraints' => [
                    new File(
                        maxSize: '5M',
                        mimeTypes: ['application/pdf'],
                        mimeTypesMessage: 'Please upload a valid PDF file.'
                    )
                ],
            ])
            ->add('portfolioLinks')
            ->add('advanceRequestedPercent')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Application::class,
        ]);
    }
}
