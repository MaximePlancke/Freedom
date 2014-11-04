<?php 

namespace Freedom\ApiBundle\Helper;

class UtilitiesApiHelper {

    public function __construct() {
    }

    public function getFormErrors(\Symfony\Component\Form\Form $form) {
   		$errors = array();

	    if ($form->count() > 0) {
	        foreach ($form->all() as $child) {
	            /**
	             * @var \Symfony\Component\Form\Form $child
	             */
	            if (!$child->isValid()) {
	                $errors[$child->getName()] = $this->getFormErrors($child);
	            }
	        }
	    } else {
	        /**
	         * @var \Symfony\Component\Form\FormError $error
	         */
	        foreach ($form->getErrors() as $key => $error) {
	            $errors[] = $error->getMessage();
	        }
	    }

	    return $errors;
	}
}