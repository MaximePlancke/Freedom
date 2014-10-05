<?php

namespace Freedom\ObjectiveBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\VirtualProperty;

/**
 * Objective
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Freedom\ObjectiveBundle\Entity\ObjectiveRepository")
 *
 * @ExclusionPolicy("all") 
 */
class Objective extends ObjectiveManager
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
    * @ORM\ManyToOne(targetEntity="Freedom\UserBundle\Entity\User")
    * @ORM\JoinColumn(nullable=false)
    * @Expose
    */
    private $user;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="text")
     * @Expose
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="category", type="string", length=255)
     * @Expose
     */
    private $category;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbsteps", type="integer")
     * @Expose
     */
    private $nbsteps;

    /**
     * @var boolean
     *
     * @ORM\Column(name="done", type="boolean")
     * @Expose
     */
    private $done;

    /**
     * @var boolean
     *
     * @ORM\Column(name="private", type="boolean")
     * @Expose
     */
    private $private;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Freedom\GroupBundle\Entity\Groups", inversedBy="objectives")
     * @ORM\JoinColumn(nullable=true)
     * @Expose
     */
    private $group;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datecreation", type="datetime")
     * @Expose
     */
    private $datecreation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dategoal", type="datetime")
     * @Expose
     */
    private $dategoal;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datedone", type="datetime")
     * @Expose
     */
    private $datedone;

    /**
    * @ORM\OneToMany(targetEntity="Freedom\ObjectiveBundle\Entity\Stepobjective", mappedBy="objective", cascade={"remove", "persist"})
    * @Expose
    */
    private $steps;

    /**
    * @ORM\OneToMany(targetEntity="Freedom\ObjectiveBundle\Entity\Advice", mappedBy="objective", cascade={"remove", "persist"})
    * @Expose
    */
    private $advices;

    /**
    * @ORM\OneToMany(targetEntity="Freedom\UserBundle\Entity\Userlikeobjective", mappedBy="objective", cascade={"remove", "persist"})
    * @Expose
    */
    private $userlikeobjectives;

    /**
    * @ORM\OneToMany(targetEntity="Freedom\UserBundle\Entity\Userfollowobjective", mappedBy="objective", cascade={"remove", "persist"})
    * @Expose
    */
    private $userfollowobjectives;

    /**
     * @var string
     *
     * @ORM\Column(name="useradvice", type="text", nullable=true)
     * @Expose
     */
    private $useradvice;
    

    public function __construct()
    {
        // $this->done = false;
        $this->datecreation = new \Datetime;
        $this->dategoal = new \Datetime;
        $this->datedone = new \Datetime;
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
     * @return Objective
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
     * Set category
     *
     * @param string $category
     * @return Objective
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return string 
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set nbsteps
     *
     * @param integer $nbsteps
     * @return Objective
     */
    public function setNbsteps($nbsteps)
    {
        $this->nbsteps = $nbsteps;

        return $this;
    }

    /**
     * Get nbsteps
     *
     * @return integer 
     */
    public function getNbsteps()
    {
        return $this->nbsteps;
    }

    /**
     * Set done
     *
     * @param boolean $done
     * @return Objective
     */
    public function setDone($done)
    {
        $this->done = $done;

        return $this;
    }

    /**
     * Get done
     *
     * @return boolean 
     */
    public function getDone()
    {
        return $this->done;
    }

    /**
     * Set datecreation
     *
     * @param \DateTime $datecreation
     * @return Objective
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
     * Set user
     *
     * @param \Freedom\UserBundle\Entity\User $user
     * @return Objective
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
     * Set private
     *
     * @param boolean $private
     * @return Objective
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
     * Add steps
     *
     * @param \Freedom\ObjectiveBundle\Entity\Stepobjective $steps
     * @return Objective
     */
    public function addStep(\Freedom\ObjectiveBundle\Entity\Stepobjective $steps)
    {
        $this->steps[] = $steps;

        return $this;
    }

    /**
     * Remove steps
     *
     * @param \Freedom\ObjectiveBundle\Entity\Stepobjective $steps
     */
    public function removeStep(\Freedom\ObjectiveBundle\Entity\Stepobjective $steps)
    {
        $this->steps->removeElement($steps);
    }

    /**
     * Get steps
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSteps()
    {
        return $this->steps;
    }

    /**
     * Set dategoal
     *
     * @param \DateTime $dategoal
     * @return Objective
     */
    public function setDategoal($dategoal)
    {
        $this->dategoal = $dategoal;

        return $this;
    }

    /**
     * Get dategoal
     *
     * @return \DateTime 
     */
    public function getDategoal()
    {
        return $this->dategoal;
    }

    /**
     * Set datedone
     *
     * @param \DateTime $datedone
     * @return Objective
     */
    public function setDatedone($datedone)
    {
        $this->datedone = $datedone;

        return $this;
    }

    /**
     * Get datedone
     *
     * @return \DateTime 
     */
    public function getDatedone()
    {
        return $this->datedone;
    }

    /**
     * Add advices
     *
     * @param \Freedom\ObjectiveBundle\Entity\Advice $advices
     * @return Objective
     */
    public function addAdvice(\Freedom\ObjectiveBundle\Entity\Advice $advices)
    {
        $this->advices[] = $advices;

        return $this;
    }

    /**
     * Remove advices
     *
     * @param \Freedom\ObjectiveBundle\Entity\Advice $advices
     */
    public function removeAdvice(\Freedom\ObjectiveBundle\Entity\Advice $advices)
    {
        $this->advices->removeElement($advices);
    }

    /**
     * Get advices
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAdvices()
    {
        return $this->advices;
    }

    /**
     * Add userlikeobjectives
     *
     * @param \Freedom\UserBundle\Entity\Userlikeobjective $userlikeobjectives
     * @return Objective
     */
    public function addUserlikeobjective(\Freedom\UserBundle\Entity\Userlikeobjective $userlikeobjectives)
    {
        $this->userlikeobjectives[] = $userlikeobjectives;

        return $this;
    }

    /**
     * Remove userlikeobjectives
     *
     * @param \Freedom\UserBundle\Entity\Userlikeobjective $userlikeobjectives
     */
    public function removeUserlikeobjective(\Freedom\UserBundle\Entity\Userlikeobjective $userlikeobjectives)
    {
        $this->userlikeobjectives->removeElement($userlikeobjectives);
    }

    /**
     * Get userlikeobjectives
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUserlikeobjectives()
    {
        return $this->userlikeobjectives;
    }

    /**
     * Set useradvice
     *
     * @param string $useradvice
     * @return Objective
     */
    public function setUseradvice($useradvice)
    {
        $this->useradvice = $useradvice;

        return $this;
    }

    /**
     * Get useradvice
     *
     * @return string 
     */
    public function getUseradvice()
    {
        return $this->useradvice;
    }

    /**
     * Add userfollowobjectives
     *
     * @param \Freedom\UserBundle\Entity\Userfollowobjective $userfollowobjectives
     * @return Objective
     */
    public function addUserfollowobjective(\Freedom\UserBundle\Entity\Userfollowobjective $userfollowobjectives)
    {
        $this->userfollowobjectives[] = $userfollowobjectives;

        return $this;
    }

    /**
     * Remove userfollowobjectives
     *
     * @param \Freedom\UserBundle\Entity\Userfollowobjective $userfollowobjectives
     */
    public function removeUserfollowobjective(\Freedom\UserBundle\Entity\Userfollowobjective $userfollowobjectives)
    {
        $this->userfollowobjectives->removeElement($userfollowobjectives);
    }

    /**
     * Get userfollowobjectives
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUserfollowobjectives()
    {
        return $this->userfollowobjectives;
    }


    /**
     * Set group
     *
     * @param \Freedom\GroupBundle\Entity\Groups $group
     * @return Objective
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
}
