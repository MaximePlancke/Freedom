<?php

namespace Freedom\UserBundle\Form\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ProfileFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('firstname')
        ->add('lastname')
        ->add('pictureFile', 'vich_file', array(
            'required'      => false,
            'mapping'       => 'profile_picture', // mandatory
            'allow_delete'  => true, // not mandatory, default is true
            'download_link' => true, // not mandatory, default is true
        ));
    }
    public function getParent()
    {
        return 'fos_user_profile';
    }

    public function getName()
    {
        return 'freedom_user_profile';
    }

}