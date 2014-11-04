<?php

namespace Freedom\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\VirtualProperty;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Userfollowobjective
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Freedom\UserBundle\Entity\UserfollowobjectiveRepository")
 * @ExclusionPolicy("all") 
 */
class Userfollowobjective
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
     * @var \Freedom\ObjectiveBundle\Entity\Objective
     * @Expose
     */
    private $objective;


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
     * @return Userfollowobjective
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
     * Set objective
     *
     * @param \Freedom\ObjectiveBundle\Entity\Objective $objective
     * @return Userfollowobjective
     */
    public function setObjective(\Freedom\ObjectiveBundle\Entity\Objective $objective = null)
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
    
}
