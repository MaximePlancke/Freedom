<?php

namespace Freedom\ObjectiveBundle\Form;

use Freedom\UserBundle\Form\UserlikeadviceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AdviceType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            // ->add(
            //     'objective', 'voryx_entity', array(
            //         'class' => 'Freedom\ObjectiveBundle\Entity\Objective'
            //     )
            // )
            // ->add('userlikeadvices', 'collection', array('type' => new UserlikeadviceType(),
            //     'allow_add'    => true,
            //     'allow_delete' => true))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Freedom\ObjectiveBundle\Entity\Advice',
            'csrf_protection' => false
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'freedom_objectivebundle_advice';
    }
}
