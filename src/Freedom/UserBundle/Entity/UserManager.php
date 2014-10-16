<?php

namespace Freedom\UserBundle\Entity;

use JMS\Serializer\Annotation\VirtualProperty;
use FOS\UserBundle\Model\User as BaseUser;

class UserManager extends BaseUser
{

    /**
     * Get friends
     * 
     * @return Array
     * @VirtualProperty 
     */
    public function getFriends() {
        $friends = array();
        $friendsList = array_merge($this->getUserfriendusers1()->toArray(), $this->getUserfriendusers2()->toArray());
        foreach ($friendsList as $key => $friend) {
            if($friend->getUser1() == $this){
                $friend->setUser1($friend->getUser2());
            }
            $reflectionClass = new \ReflectionClass(get_class($friend));
            foreach ($reflectionClass->getProperties() as $property) {
                $property->setAccessible(true);
                $friends[$key][$property->getName()] = $property->getValue($friend);
                $property->setAccessible(false);
            }
            unset($friends[$key]['user2']);
        }
        
        return $friends;
    }

    /**
     * Get isFriend
     * 
     * @return Array
     */
    public function getIsFriend($user) {
        $isFriend = false;
        $accepted = false;
        $asked = false;
        $able = true;
        if($user != $this){
            $able = true;
            $friendsList = array_merge($this->getUserfriendusers1()->toArray(), $this->getUserfriendusers2()->toArray());
            foreach ($friendsList as $key => $friend) {
                if($friend->getUser1() == $user){
                    $asked = true; //Current user asked
                    $isFriend = true;
                    $accepted = $friend->getAccepted();
                }
                if($friend->getUser2() == $user){
                    $asked = false; //profile user asked
                    $isFriend = true; 
                    $accepted = $friend->getAccepted();
                }
            }    
        } else {
            $able = false;
        }
        return array('isFriend' => $isFriend, 'accepted' => $accepted, 'asked' => $asked, 'able' => $able);  
    }


}