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
     * @var \Freedom\UserBundle\Entity\User
     * @Expose
     */
    private $user;

    /**
     * @var \Freedom\UserBundle\Entity\User
     * @Expose
     */
    private $user2;

    /**
     * @var boolean
     */
    private $accepted;

    /**
     * @var \DateTime
     */
    private $datecreation;


    public function __construct()
    {
        $this->datecreation = new \Datetime;
        $this->accepted = false;
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
     * Set user
     *
     * @param \Freedom\UserBundle\Entity\User $user
     * @return Userfrienduser
     */
    public function setUser(\Freedom\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Freedom\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
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
}
