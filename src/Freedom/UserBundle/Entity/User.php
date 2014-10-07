<?php

namespace Freedom\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="fos_user")
 * @ORM\Entity(repositoryClass="Freedom\UserBundle\Entity\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    // /**
    //  * Get id
    //  *
    //  * @return integer 
    //  */
    // public function getId()
    // {
    //     return $this->id;
    // }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $userfriendusers;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $userfriendusers2;
    

    public function __construct()
    {
        parent::__construct();

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
     * Add userfriendusers
     *
     * @param \Freedom\UserBundle\Entity\Userfrienduser $userfriendusers
     * @return User
     */
    public function addUserfrienduser(\Freedom\UserBundle\Entity\Userfrienduser $userfriendusers)
    {
        $this->userfriendusers[] = $userfriendusers;

        return $this;
    }

    /**
     * Remove userfriendusers
     *
     * @param \Freedom\UserBundle\Entity\Userfrienduser $userfriendusers
     */
    public function removeUserfrienduser(\Freedom\UserBundle\Entity\Userfrienduser $userfriendusers)
    {
        $this->userfriendusers->removeElement($userfriendusers);
    }

    /**
     * Get userfriendusers
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUserfriendusers()
    {
        return $this->userfriendusers;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $objectives;


    /**
     * Add objectives
     *
     * @param \Freedom\ObjectiveBundle\Entity\Objective $objectives
     * @return User
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
     * Add userfriendusers2
     *
     * @param \Freedom\UserBundle\Entity\Userfrienduser $userfriendusers2
     * @return User
     */
    public function addUserfriendusers2(\Freedom\UserBundle\Entity\Userfrienduser $userfriendusers2)
    {
        $this->userfriendusers2[] = $userfriendusers2;

        return $this;
    }

    /**
     * Remove userfriendusers2
     *
     * @param \Freedom\UserBundle\Entity\Userfrienduser $userfriendusers2
     */
    public function removeUserfriendusers2(\Freedom\UserBundle\Entity\Userfrienduser $userfriendusers2)
    {
        $this->userfriendusers2->removeElement($userfriendusers2);
    }

    /**
     * Get userfriendusers2
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUserfriendusers2()
    {
        return $this->userfriendusers2;
    }
}
