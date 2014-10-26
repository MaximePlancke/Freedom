<?php

namespace Freedom\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\VirtualProperty;

/**
 * Userfrienduser
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Freedom\UserBundle\Entity\UserfrienduserRepository")
 * @ExclusionPolicy("all") 
 */
class Userfrienduser
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Expose
     */
    private $id;


    /**
     * @var boolean
     * @Expose
     */
    private $accepted;

    /**
     * @var boolean
     * @Expose
     */
    private $seen;

    /**
     * @var \DateTime
     * @Expose
     */
    private $datecreation;

    /**
     * @var \Freedom\UserBundle\Entity\User
     * @Expose
     */
    private $user1;

    /**
     * @var \Freedom\UserBundle\Entity\User
     * @Expose
     */
    private $user2;


    public function __construct(){
        $this->accepted = false;
        $this->seen = false;
        $this->datecreation = new \Datetime;
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
     * Set accepted
     *
     * @param boolean $accepted
     * @return Userfrienduser
     */
    public function setAccepted($accepted)
    {
        $this->accepted = $accepted;

        return $this;
    }

    /**
     * Get accepted
     *
     * @return boolean 
     */
    public function getAccepted()
    {
        return $this->accepted;
    }

    /**
     * Set datecreation
     *
     * @param \DateTime $datecreation
     * @return Userfrienduser
     */
    public function setDatecreation($datecreation)
    {
        $this->datecreation = $datecreation;

        return $this;
    }

    /**
     * Get datecreation
     *
     * @return \DateTime 
     */
    public function getDatecreation()
    {
        return $this->datecreation;
    }

    /**
     * Set user1
     *
     * @param \Freedom\UserBundle\Entity\User $user1
     * @return Userfrienduser
     */
    public function setUser1(\Freedom\UserBundle\Entity\User $user1 = null)
    {
        $this->user1 = $user1;

        return $this;
    }

    /**
     * Get user1
     *
     * @return \Freedom\UserBundle\Entity\User 
     */
    public function getUser1()
    {
        return $this->user1;
    }

    /**
     * Set user2
     *
     * @param \Freedom\UserBundle\Entity\User $user2
     * @return Userfrienduser
     */
    public function setUser2(\Freedom\UserBundle\Entity\User $user2 = null)
    {
        $this->user2 = $user2;

        return $this;
    }

    /**
     * Get user2
     *
     * @return \Freedom\UserBundle\Entity\User 
     */
    public function getUser2()
    {
        return $this->user2;
    }


    /**
     * Set seen
     *
     * @param boolean $seen
     * @return Userfrienduser
     */
    public function setSeen($seen)
    {
        $this->seen = $seen;

        return $this;
    }

    /**
     * Get seen
     *
     * @return boolean 
     */
    public function getSeen()
    {
        return $this->seen;
    }
}
