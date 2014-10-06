<?php

namespace Freedom\ObjectiveBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ObjectiveCreateType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
    ->add('done', 'choice', array(
        'choices'   => array(
            false   => 'Objectif',
            true => 'Expérience',
        ),
    ))
    ->add('name',        'textarea')
    ->add('category', 'choice', array(
        'choices'   => array(
            'personnel'   => 'Personnel',
            'sportif' => 'Sportif',
            'professionnel'   => 'Professionnel',
            'fun' => 'Fun',
        ),
    ))
    ->add('private', 'choice', array(
        'choices'   => array(
            true   => 'Oui',
            false => 'Non',
        ),
    ))
    ->add('dategoal', 'date')
    ->add('useradvice', 'textarea', array('required' => false))
    ->add('steps', 'collection', array('type' => new StepobjectiveCreateType(),
        'allow_add'    => true,
        'allow_delete' => true))
    ;
}

public function setDefaultOptions(OptionsResolverInterface $resolver)
{
    $resolver->setDefaults(array(
      'data_class' => 'Freedom\ObjectiveBundle\Entity\Objective'
      ));
}

public function getName()
{
    return 'freedom_objectivebundle_objectivetype';
}
}