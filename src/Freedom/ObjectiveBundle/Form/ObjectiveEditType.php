<?php

namespace Freedom\ObjectiveBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ObjectiveEditType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
    ->add('done', 'checkbox', array(
        'label'     => 'Have you completed this objective already? ',
        'required'  => false,
    ))
    ->add('name', 'text')
    ->add('category', 'choice', array(
        'choices'   => array(
            'personnel'   => 'Personnel',
            'sportif' => 'Sportif',
            'professionnel'   => 'Professionnel',
            'fun' => 'Fun',
        ),
    ))
    ->add('private', 'checkbox', array(
        'label'     => 'Is it a private objective? ',
        'required'  => false,
    ))
    ->add('dategoal', 'date', array(
        'widget' => 'single_text',
        'input' => 'datetime',
        'format' => 'dd/MM/yyyy',
        'attr' => array('class' => 'date'),
        ))
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