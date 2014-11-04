<?php

namespace Freedom\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Freedom\ObjectiveBundle\Form\ObjectiveType;

class UserfollowobjectiveType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // ->add('user', 'collection', array('type' => new UserType()))
            // ->add('objective', 'collection', array('type' => new ObjectiveType()))
            // ->add('user', 'entity', array(
            //     'class' => 'Freedom\UserBundle\Entity\User'
            //   ))
            // ->add('objective', 'entity', array(
            //     'class' => 'Freedom\ObjectiveBundle\Entity\Objective'
            //   ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Freedom\UserBundle\Entity\Userfollowobjective',
            'csrf_protection' => false
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'freedom_userbundle_userfollowobjective';
    }
}
