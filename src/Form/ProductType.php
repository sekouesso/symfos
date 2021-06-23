<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('category',EntityType::class,['class' => Category::class,
                                               'choice_label' => 'name',
                                               'label' => 'Catégorie'])
            ->add('name')
            ->add('description', TextareaType::class)
            ->add('price')
            ->add('quantity')
            ->add('imageFile', VichImageType::class )
            ->add('selected')
            ->add('available')
            ->add('promotion')
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}