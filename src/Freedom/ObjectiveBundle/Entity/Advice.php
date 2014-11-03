<?php

namespace Freedom\ObjectiveBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\VirtualProperty;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Advice
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Freedom\ObjectiveBundle\Entity\AdviceRepository")
 * @ExclusionPolicy("all") 
 */
class Advice
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
    * @ORM\ManyToOne(targetEntity="Freedom\ObjectiveBundle\Entity\Objective", inversedBy="advices")
    * @ORM\JoinColumn(nullable=false)
    * @Expose
    */
    private $objective;

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
     * @Assert\Type(type="string", message="the value {{ value }} is not a valid {{ type }}.")
     */
    private $name;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datecreation", type="datetime")
     * @Expose
     */
    private $datecreation;

    /**
    * @ORM\OneToMany(targetEntity="Freedom\UserBundle\Entity\Userlikeadvice", mappedBy="advice", cascade={"remove", "persist"})
    * @Expose
    */
    private $userlikeadvices;


    public function __construct()
    {
        $this->datecreation = new \Datetime;
        $this->userlikeadvices = new ArrayCollection;
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
     * @return Advice
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
     * Set datecreation
     *
     * @param \DateTime $datecreation
     * @return Advice
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
     * @return Advice
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
     * Set user
     *
     * @param \Freedom\UserBundle\Entity\User $user
     * @return Advice
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
     * Add userlikeadvices
     *
     * @param \Freedom\UserBundle\Entity\Userlikeadvice $userlikeadvices
     * @return Advice
     */
    public function addUserlikeadvice(\Freedom\UserBundle\Entity\Userlikeadvice $userlikeadvices)
    {
        $this->userlikeadvices[] = $userlikeadvices;

        return $this;
    }

    /**
     * Remove userlikeadvices
     *
     * @param \Freedom\UserBundle\Entity\Userlikeadvice $userlikeadvices
     */
    public function removeUserlikeadvice(\Freedom\UserBundle\Entity\Userlikeadvice $userlikeadvices)
    {
        $this->userlikeadvices->removeElement($userlikeadvices);
    }

    /**
     * Get userlikeadvices
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUserlikeadvices()
    {
        return $this->userlikeadvices;
    }
}
