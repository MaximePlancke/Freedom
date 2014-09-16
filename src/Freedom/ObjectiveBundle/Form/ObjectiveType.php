<?php

namespace Freedom\ObjectiveBundle\Form;

use Freedom\UserBundle\Form\UserlikeobjectiveType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ObjectiveType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('category')
            ->add('nbsteps')
            ->add('done')
            ->add('private')
            ->add('groups')
            ->add('dategoal', 'datetime', array(
                'widget' => 'single_text',
                ))
            ->add('datedone', 'datetime', array(
                'widget' => 'single_text',
                ))
            // ->add('advices', 'collection', array('type' => new AdviceType(),
            //     'allow_add'    => true,
            //     'allow_delete' => true,
            //     'by_reference' => false))
            // ->add('steps', 'collection', array('type' => new StepobjectiveType(),
            //     'allow_add'    => true,
            //     'allow_delete' => true))
            // ->add('userlikeobjectives', 'collection', array('type' => new UserlikeobjectiveType(),
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
            'data_class' => 'Freedom\ObjectiveBundle\Entity\Objective', 
            'csrf_protection' => false
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'freedom_objectivebundle_objective';
    }
}
