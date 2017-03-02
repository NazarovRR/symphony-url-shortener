<?php

namespace AppBundle\Form;

use AppBundle\Entity\Url;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('full_url', TextType::class,array('required'=>TRUE, 'error_bubbling'=>TRUE, 'attr' => array(
                'placeholder' => 'Url to be shorten',
            ),))
            ->add('encoded', TextType::class,array('required'=>FALSE, 'error_bubbling'=>TRUE, 'attr' => array(
                'placeholder' => 'Short url',
            ),))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Url::class
        ]);
    }

    public function getBlockPrefix()
    {
        return 'app_bundle_post_form_type';
    }
}
