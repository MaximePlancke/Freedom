<?php

namespace Freedom\GroupBundle\Entity;

use JMS\Serializer\Annotation\VirtualProperty;

class GroupsManager
{
    /**
     * Get Userbelong
     * 
     * @return Array
     */
    public function getUserBelong($userBelong) {
        $belong = false;
        $accepted = false;
        $data = null;
        foreach ($this->getUserbelonggroups() as $key => $userbelong) {
            if($userbelong->getUser() == $userBelong){
                $belong = true;
                $accepted = $userbelong->getAccepted();
                $data = $userbelong;
            }
        }    
        return array('data' => $data ,'belong' => $belong, 'accepted' => $accepted, 'private' => $this->getPrivate() , 'groupId' => $this->getId());  
    }
}