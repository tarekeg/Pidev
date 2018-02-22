<?php

namespace Ecommerce\EcommerceBundle\Form;

use Ecommerce\EcommerceBundle\Entity\Categories;
use Ecommerce\EcommerceBundle\Entity\Media;
use Ecommerce\EcommerceBundle\Entity\Tva;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Ecommerce\EcommerceBundle\Form\MediaType;

class ProduitsType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom')
                ->add('description')
                ->add('prix')
                ->add('disponible')
                ->add('image',MediaType::class)
                ->add('tva',EntityType::class,array(
                    'class'=>Tva::class,
                    'choice_label'=>'valeur',
                    'multiple'=>false))
                ->add('categorie',EntityType::class,array(
                    'class'=>Categories::class,
                    'choice_label'=>'nom',
                    'multiple'=>false));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Ecommerce\EcommerceBundle\Entity\Produits'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'ecommerce_ecommercebundle_produits';
    }


}
