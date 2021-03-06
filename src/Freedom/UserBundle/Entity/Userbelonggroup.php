<?php

namespace Freedom\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\VirtualProperty;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Userbelonggroup
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Freedom\UserBundle\Entity\UserbelonggroupRepository")
 * @ExclusionPolicy("all") 
 */
class Userbelonggroup
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
     * @var integer
     *
     * @ORM\Column(name="role", type="integer")
     * @Expose
     * @Assert\Type(type="integer", message="the value {{ value }} is not a valid {{ type }}.")
     * @Assert\Range(
     *      min = 1,
     *      max = 2,
     *      minMessage = "This role doesn't exist",
     *      maxMessage = "This role doesn't exist"
     * )
     */
    private $role;

    /**
     * @var \Freedom\UserBundle\Entity\User
     * @Expose
     */
    private $user;

    /**
     * @var \Freedom\GroupBundle\Entity\Groups
     * @Expose
     */
    private $group;

    /**
     * @var boolean
     * @Expose
     * @Assert\Type(type="boolean", message="the value {{ value }} is not a valid {{ type }}.")
     */
    private $accepted;
    
    /**
     * @var boolean
     * @Assert\Type(type="boolean", message="the value {{ value }} is not a valid {{ type }}.")
     */
    private $seen;

    public function __construct(){
        $this->seen = false;
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
     * @return Userbelonggroup
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
     * Set group
     *
     * @param \Freedom\GroupBundle\Entity\Groups $group
     * @return Userbelonggroup
     */
    public function setGroup(\Freedom\GroupBundle\Entity\Groups $group = null)
    {
        $this->group = $group;

        return $this;
    }

    /**
     * Get group
     *
     * @return \Freedom\GroupBundle\Entity\Groups 
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * Set role
     *
     * @param integer $role
     * @return Userbelonggroup
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return integer 
     */
    public function getRole()
    {
        return $this->role;
    }


    /**
     * Set accepted
     *
     * @param boolean $accepted
     * @return Userbelonggroup
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
     * Set seen
     *
     * @param boolean $seen
     * @return Userbelonggroup
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
