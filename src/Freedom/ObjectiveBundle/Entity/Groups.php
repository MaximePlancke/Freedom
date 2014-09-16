<?php

namespace Freedom\ObjectiveBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Groups
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Freedom\ObjectiveBundle\Entity\GroupsRepository")
 */
class Groups
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
    * @ORM\ManyToMany(targetEntity="Freedom\ObjectiveBundle\Entity\Objective", cascade={"persist"})
    */
    private $objectives;

    /**
    * @ORM\ManyToMany(targetEntity="Freedom\UserBundle\Entity\User", cascade={"persist"})
    */
    private $users;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var boolean
     *
     * @ORM\Column(name="private", type="boolean")
     */
    private $private;

    /**
     * @var integer
     *
     * @ORM\Column(name="rate", type="integer")
     */
    private $rate;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->objectives = new \Doctrine\Common\Collections\ArrayCollection();
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add users
     *
     * @param \Freedom\UserBundle\Entity\User $users
     * @return Groups
     */
    public function addUser(\Freedom\UserBundle\Entity\User $users)
    {
        $this->users[] = $users;

        return $this;
    }

    /**
     * Remove users
     *
     * @param \Freedom\UserBundle\Entity\User $users
     */
    public function removeUser(\Freedom\UserBundle\Entity\User $users)
    {
        $this->users->removeElement($users);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUsers()
    {
        return $this->users;
    }
}
