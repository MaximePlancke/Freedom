<?php

namespace Freedom\ObjectiveBundle\Entity;

use JMS\Serializer\Annotation\VirtualProperty;

class ObjectiveManager
{

    /**
     * Get number of days left
     * 
     * @return String
     * @VirtualProperty 
     */
    public function getNumberOfDays() {
    	if ($this->getDone() == true) {
    		return 'Done';
    	}
        $now = new \DateTime;
        $date = $this->getDategoal();
        $diff = $now->diff($date)->format("%R%a");
        if($diff == 0) { $diff = 'Today!';}
        elseif($diff < 0) {$diff = 'Too late!';}
        else { $diff = substr($diff,1).' days left';}
        
        return $diff;
    }


}