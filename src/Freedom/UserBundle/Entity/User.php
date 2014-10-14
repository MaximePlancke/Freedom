<?php

namespace Freedom\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\VirtualProperty;

/**
 * User
 *
 * @ORM\Table(name="fos_user")
 * @ORM\Entity(repositoryClass="Freedom\UserBundle\Entity\UserRepository")
 * @ExclusionPolicy("all") 
 */
class User extends UserManager
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Expose
     */
    protected $id;

   
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $userfriendusers1;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $userfriendusers2;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $usernotifications;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->userfriendusers1 = new \Doctrine\Common\Collections\ArrayCollection();
        $this->userfriendusers2 = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Add userfriendusers1
     *
     * @param \Freedom\UserBundle\Entity\Userfrienduser $userfriendusers1
     * @return User
     */
    public function addUserfriendusers1(\Freedom\UserBundle\Entity\Userfrienduser $userfriendusers1)
    {
        $this->userfriendusers1[] = $userfriendusers1;

        return $this;
    }

    /**
     * Remove userfriendusers1
     *
     * @param \Freedom\UserBundle\Entity\Userfrienduser $userfriendusers1
     */
    public function removeUserfriendusers1(\Freedom\UserBundle\Entity\Userfrienduser $userfriendusers1)
    {
        $this->userfriendusers1->removeElement($userfriendusers1);
    }

    /**
     * Get userfriendusers1
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUserfriendusers1()
    {
        return $this->userfriendusers1;
    }

    /**
     * Add userfriendusers2
     *
     * @param \Freedom\UserBundle\Entity\Userfrienduser $userfriendusers2
     * @return User
     */
    public function addUserfriendusers2(\Freedom\UserBundle\Entity\Userfrienduser $userfriendusers2)
    {
        $this->userfriendusers2[] = $userfriendusers2;

        return $this;
    }

    /**
     * Remove userfriendusers2
     *
     * @param \Freedom\UserBundle\Entity\Userfrienduser $userfriendusers2
     */
    public function removeUserfriendusers2(\Freedom\UserBundle\Entity\Userfrienduser $userfriendusers2)
    {
        $this->userfriendusers2->removeElement($userfriendusers2);
    }

    /**
     * Get userfriendusers2
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUserfriendusers2()
    {
        return $this->userfriendusers2;
    }

    /**
     * Add usernotifications
     *
     * @param \Freedom\UserBundle\Entity\Notification $usernotifications
     * @return User
     */
    public function addUsernotifications(\Freedom\UserBundle\Entity\Notification $usernotifications)
    {
        $this->usernotifications[] = $usernotifications;

        return $this;
    }

    /**
     * Remove usernotifications
     *
     * @param \Freedom\UserBundle\Entity\Notification $usernotifications
     */
    public function removeUsernotifications(\Freedom\UserBundle\Entity\Notification $usernotifications)
    {
        $this->usernotifications->removeElement($usernotifications);
    }

    /**
     * Get usernotifications
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUsernotifications()
    {
        return $this->usernotifications;
    }
}
