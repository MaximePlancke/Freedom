<?php

namespace Freedom\GroupBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups as GroupsJMS;
use JMS\Serializer\Annotation\VirtualProperty;

/**
 * Groups
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Freedom\GroupBundle\Entity\GroupsRepository")
 *
 * @ExclusionPolicy("all") 
 */
class Groups extends GroupsManager
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
    * @ORM\OneToMany(targetEntity="Freedom\ObjectiveBundle\Entity\Objective", mappedBy="group", cascade={"remove", "persist"})
    * @Expose
    */
    private $objectives;

    /**
    * @ORM\OneToMany(targetEntity="Freedom\UserBundle\Entity\Userbelonggroup", mappedBy="group", cascade={"remove", "persist"})
    * @Expose
    * @GroupsJMS({"Me"})
    */
    private $userbelonggroups;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Expose
     */
    private $name;

    /**
     * @var boolean
     *
     * @ORM\Column(name="private", type="boolean")
     * @Expose
     */
    private $private;

    /**
    * @ORM\ManyToOne(targetEntity="Freedom\UserBundle\Entity\User", inversedBy="owngroups")
    * @ORM\JoinColumn(nullable=false)
    * @Expose
    */
    private $user;

    /**
     * @var integer
     *
     * @ORM\Column(name="rate", type="integer")
     * @Expose
     */
    private $rate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datecreation", type="datetime")
     * @Expose
     */
    private $datecreation;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     * @Expose
     */
    private $description;


    public function __construct()
    {
        $this->rate = 5;
        $this->datecreation = new \Datetime;
        $this->objectives = new ArrayCollection;
        $this->userbelonggroups = new ArrayCollection;
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
     * Set name
     *
     * @param string $name
     * @return Groups
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set private
     *
     * @param boolean $private
     * @return Groups
     */
    public function setPrivate($private)
    {
        $this->private = $private;

        return $this;
    }

    /**
     * Get private
     *
     * @return boolean 
     */
    public function getPrivate()
    {
        return $this->private;
    }

    /**
     * Set user
     *
     * @param \Freedom\UserBundle\Entity\User $user
     * @return Groups
     */
    public function setUser(\Freedom\UserBundle\Entity\User $user)
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
     * Set rate
     *
     * @param integer $rate
     * @return Groups
     */
    public function setRate($rate)
    {
        $this->rate = $rate;

        return $this;
    }

    /**
     * Get rate
     *
     * @return integer 
     */
    public function getRate()
    {
        return $this->rate;
    }


    /**
     * Add objectives
     *
     * @param \Freedom\ObjectiveBundle\Entity\Objective $objectives
     * @return Groups
     */
    public function addObjective(\Freedom\ObjectiveBundle\Entity\Objective $objectives)
    {
        $this->objectives[] = $objectives;

        return $this;
    }

    /**
     * Remove objectives
     *
     * @param \Freedom\ObjectiveBundle\Entity\Objective $objectives
     */
    public function removeObjective(\Freedom\ObjectiveBundle\Entity\Objective $objectives)
    {
        $this->objectives->removeElement($objectives);
    }

    /**
     * Get objectives
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getObjectives()
    {
        return $this->objectives;
    }

    /**
     * Add userbelonggroups
     *
     * @param \Freedom\UserBundle\Entity\Userbelonggroup $userbelonggroups
     * @return Groups
     */
    public function addUserbelonggroups(\Freedom\UserBundle\Entity\Userbelonggroup $userbelonggroups)
    {
        $this->userbelonggroups[] = $userbelonggroups;

        return $this;
    }

    /**
     * Remove userbelonggroups
     *
     * @param \Freedom\UserBundle\Entity\Userbelonggroup $userbelonggroups
     */
    public function removeUserbelonggroups(\Freedom\UserBundle\Entity\Userbelonggroup $userbelonggroups)
    {
        $this->userbelonggroups->removeElement($userbelonggroups);
    }

    /**
     * Get userbelonggroups
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUserbelonggroups()
    {
        return $this->userbelonggroups;
    }

    /**
     * Set datecreation
     *
     * @param \DateTime $datecreation
     * @return Groups
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
     * Set description
     *
     * @param string $description
     * @return Group
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }
}
