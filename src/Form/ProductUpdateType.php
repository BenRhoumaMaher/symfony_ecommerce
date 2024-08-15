<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\SubCategory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ProductUpdateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('price')
            ->add(
                'image',
                FileType::class,
                [
                    'label' => 'picture of the product',
                    'mapped' => false,
                    'required' => false,
                    "constraints" => [
                        new File(
                            [
                                "maxSize" => "1024k",
                                "mimeTypes" => [
                                    'image/jpg',
                                    'image/png',
                                    'image/jpeg'
                                ],
                                'maxSizeMessage' =>
                                    "your image must not pass 1024M",
                                'mimeTypesMessage' =>
                                    "your product image must be in valid format (png, jpg, jpeg)"
                            ]
                        )
                    ]
                ]
            )
            ->add('subCategories', EntityType::class, [
                'class' => SubCategory::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}