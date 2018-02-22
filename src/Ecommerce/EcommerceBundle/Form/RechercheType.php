<?php

namespace Ecommerce\EcommerceBundle\Form;

use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RechercheType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('recherche',TextType::class,array('label' => false,
                                                                  'attr' => array('class' => 'input-medium search-query')));
    }

    public function configureOptions(OptionsResolver $resolver)
    {

    }

    public function getBlockPrefix()
    {
        return 'ecommerce_bundle_recherche_type';
    }
}
