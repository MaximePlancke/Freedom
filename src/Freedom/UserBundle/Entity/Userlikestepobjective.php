<?php

namespace Freedom\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\VirtualProperty;

/**
 * Userlikestepobjective
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Freedom\UserBundle\Entity\UserlikestepobjectiveRepository")
 * @ExclusionPolicy("all") 
 */
class Userlikestepobjective
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
     * @var \Freedom\ObjectiveBundle\Entity\Stepobjective
     * @Expose
     */
    private $stepobjective;


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
     * @return Userlikestepobjective
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
     * Set stepobjective
     *
     * @param \Freedom\ObjectiveBundle\Entity\Stepobjective $stepobjective
     * @return Userlikestepobjective
     */
    public function setStepobjective(\Freedom\ObjectiveBundle\Entity\Stepobjective $stepobjective = null)
    {
        $this->stepobjective = $stepobjective;

        return $this;
    }

    /**
     * Get stepobjective
     *
     * @return \Freedom\ObjectiveBundle\Entity\Stepobjective 
     */
    public function getStepobjective()
    {
        return $this->stepobjective;
    }
  

}
