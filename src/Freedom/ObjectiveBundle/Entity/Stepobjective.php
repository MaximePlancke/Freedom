<?php

namespace Freedom\ObjectiveBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\VirtualProperty;

/**
 * Stepobjective
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Freedom\ObjectiveBundle\Entity\StepobjectiveRepository")
 * @ExclusionPolicy("all") 
 */
class Stepobjective
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
    * @ORM\ManyToOne(targetEntity="Freedom\ObjectiveBundle\Entity\Objective", inversedBy="steps")
    * @ORM\JoinColumn(nullable=false)
    * @Expose
    */
    private $objective;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="text")
     * @Expose
     */
    private $name;

    /**
     * @var boolean
     *
     * @ORM\Column(name="done", type="boolean")
     * @Expose
     */
    private $done;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datecreation", type="datetime")
     * @Expose
     */
    private $datecreation;

    /**
    * @ORM\OneToMany(targetEntity="Freedom\UserBundle\Entity\Userlikestepobjective", mappedBy="stepobjective", cascade={"remove", "persist"})
    * @Expose
    */
    private $userlikestepobjectives;

    public function __construct()
    {
        $this->done = false;
        $this->datecreation = new \Datetime;
        $this->userlikestepobjectives = new ArrayCollection;
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
     * @return Stepobjective
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
     * Set done
     *
     * @param boolean $done
     * @return Stepobjective
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
     * @return Stepobjective
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
     * Set objective
     *
     * @param \Freedom\ObjectiveBundle\Entity\Objective $objective
     * @return Stepobjective
     */
    public function setObjective(\Freedom\ObjectiveBundle\Entity\Objective $objective)
    {
        $this->objective = $objective;

        return $this;
    }

    /**
     * Get objective
     *
     * @return \Freedom\ObjectiveBundle\Entity\Objective 
     */
    public function getObjective()
    {
        return $this->objective;
    }

    /**
     * Add userlikestepobjectives
     *
     * @param \Freedom\UserBundle\Entity\Userlikestepobjective $userlikestepobjectives
     * @return Stepobjective
     */
    public function addUserlikestepobjective(\Freedom\UserBundle\Entity\Userlikestepobjective $userlikestepobjectives)
    {
        $this->userlikestepobjectives[] = $userlikestepobjectives;

        return $this;
    }

    /**
     * Remove userlikestepobjectives
     *
     * @param \Freedom\UserBundle\Entity\Userlikestepobjective $userlikestepobjectives
     */
    public function removeUserlikestepobjective(\Freedom\UserBundle\Entity\Userlikestepobjective $userlikestepobjectives)
    {
        $this->userlikestepobjectives->removeElement($userlikestepobjectives);
    }

    /**
     * Get userlikestepobjectives
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUserlikestepobjectives()
    {
        return $this->userlikestepobjectives;
    }
}
