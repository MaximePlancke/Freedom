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
        // $asked = false;
        // $able = true;
        $data = null;
        // if($userFriend != $this){
            // $able = true;
            // $friendsList = array_merge($this->getUserfriendusers1()->toArray(), $this->getUserfriendusers2()->toArray());
            foreach ($this->getUserbelonggroups() as $key => $userbelong) {
                if($userbelong->getUser() == $userBelong){
                    // $asked = true; 
                    $belong = true;
                    $accepted = $userbelong->getAccepted();
                    $data = $userbelong;
                }
            }    
        // } else {
        //     $able = false;
        // }
        return array('data' => $data ,'belong' => $belong, 'accepted' => $accepted, 'groupId' => $this->getId());  
    }
}