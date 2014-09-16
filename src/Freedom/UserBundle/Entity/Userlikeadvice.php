<?php

namespace Freedom\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\VirtualProperty;

/**
 * Userlikeadvice
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Freedom\UserBundle\Entity\UserlikeadviceRepository")
 * @ExclusionPolicy("all") 
 */
class Userlikeadvice
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
     * @var \Freedom\ObjectiveBundle\Entity\Advice
     * @Expose
     */
    private $advice;


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
     * @return Userlikeadvice
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
     * Set advice
     *
     * @param \Freedom\ObjectiveBundle\Entity\Advice $advice
     * @return Userlikeadvice
     */
    public function setAdvice(\Freedom\ObjectiveBundle\Entity\Advice $advice = null)
    {
        $this->advice = $advice;

        return $this;
    }

    /**
     * Get advice
     *
     * @return \Freedom\ObjectiveBundle\Entity\Advice 
     */
    public function getAdvice()
    {
        return $this->advice;
    }
  

}
