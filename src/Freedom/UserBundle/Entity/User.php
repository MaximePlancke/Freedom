<?php

namespace Freedom\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\VirtualProperty;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * User
 *
 * @ORM\Table(name="fos_user")
 * @ORM\Entity(repositoryClass="Freedom\UserBundle\Entity\UserRepository")
 * @ExclusionPolicy("all") 
 * @Vich\Uploadable
 * @ORM\HasLifecycleCallbacks
 */
class User extends UserManager
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Expose
     */
    protected $id;

    /**
     * @var string
     * @Assert\NotBlank(message="Please enter your firstname.")
     * @Assert\Length(
     *     min=2,
     *     max="25",
     *     minMessage="The name is too short.",
     *     maxMessage="The name is too long."
     * )
     */
    private $firstname;

    /**
     * @var string
     * @Assert\NotBlank(message="Please enter your name.")
     * @Assert\Length(
     *     min=2,
     *     max="25",
     *     minMessage="The name is too short.",
     *     maxMessage="The name is too long."
     * )
     */
    private $lastname;
   
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $userfriendusers1;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $userfriendusers2;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $usernotifications;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * @Expose
     * @Groups({"Me"})
     */
    private $owngroups;

    /**
     * @Vich\UploadableField(mapping="profile_picture", fileNameProperty="pictureName")
     *
     * @Assert\File(
     * maxSize="7M",
     * mimeTypes={"image/png", "image/jpeg", "image/pjpeg"},
     * mimeTypesMessage = "Please upload a valid Image"
     * )
     * @var File $imageFile
     */
    protected $pictureFile;

    /**
     * @ORM\Column(type="string", length=255, name="picture_name")
     *
     * @var string $pictureName
     * @Expose
     */
    protected $pictureName;

    /**
     * @var \DateTime
     */
    private $pictureUpdatedAt;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->pictureName = 'profileDefaultImage.jpeg';
        $this->pictureUpdatedAt = new \DateTime;
        $this->userfriendusers1 = new \Doctrine\Common\Collections\ArrayCollection();
        $this->userfriendusers2 = new \Doctrine\Common\Collections\ArrayCollection();
        $this->usernotifications = new \Doctrine\Common\Collections\ArrayCollection();
        $this->owngroups = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add userfriendusers1
     *
     * @param \Freedom\UserBundle\Entity\Userfrienduser $userfriendusers1
     * @return User
     */
    public function addUserfriendusers1(\Freedom\UserBundle\Entity\Userfrienduser $userfriendusers1)
    {
        $this->userfriendusers1[] = $userfriendusers1;

        return $this;
    }

    /**
     * Remove userfriendusers1
     *
     * @param \Freedom\UserBundle\Entity\Userfrienduser $userfriendusers1
     */
    public function removeUserfriendusers1(\Freedom\UserBundle\Entity\Userfrienduser $userfriendusers1)
    {
        $this->userfriendusers1->removeElement($userfriendusers1);
    }

    /**
     * Get userfriendusers1
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUserfriendusers1()
    {
        return $this->userfriendusers1;
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

    /**
     * Add usernotifications
     *
     * @param \Freedom\UserBundle\Entity\Notification $usernotifications
     * @return User
     */
    public function addUsernotifications(\Freedom\UserBundle\Entity\Notification $usernotifications)
    {
        $this->usernotifications[] = $usernotifications;

        return $this;
    }

    /**
     * Remove usernotifications
     *
     * @param \Freedom\UserBundle\Entity\Notification $usernotifications
     */
    public function removeUsernotifications(\Freedom\UserBundle\Entity\Notification $usernotifications)
    {
        $this->usernotifications->removeElement($usernotifications);
    }

    /**
     * Get usernotifications
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUsernotifications()
    {
        return $this->usernotifications;
    }

    /**
     * Add usernotifications
     *
     * @param \Freedom\UserBundle\Entity\Notification $usernotifications
     * @return User
     */
    public function addUsernotification(\Freedom\UserBundle\Entity\Notification $usernotifications)
    {
        $this->usernotifications[] = $usernotifications;

        return $this;
    }

    /**
     * Remove usernotifications
     *
     * @param \Freedom\UserBundle\Entity\Notification $usernotifications
     */
    public function removeUsernotification(\Freedom\UserBundle\Entity\Notification $usernotifications)
    {
        $this->usernotifications->removeElement($usernotifications);
    }


    /**
     * Add owngroups
     *
     * @param \Freedom\GroupBundle\Entity\Groups $owngroups
     * @return User
     */
    public function addOwngroup(\Freedom\GroupBundle\Entity\Groups $owngroups)
    {
        $this->owngroups[] = $owngroups;

        return $this;
    }

    /**
     * Remove owngroups
     *
     * @param \Freedom\GroupBundle\Entity\Groups $owngroups
     */
    public function removeOwngroup(\Freedom\GroupBundle\Entity\Groups $owngroups)
    {
        $this->owngroups->removeElement($owngroups);
    }

    /**
     * Get owngroups
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOwngroups()
    {
        return $this->owngroups;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     * @return User
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string 
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     * @return User
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string 
     */
    public function getLastname()
    {
        return $this->lastname;
    }



    /**
     * Set pictureFile
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $pictureFile
     */
    public function setPictureFile(File $pictureFile)
    {
        $this->pictureFile = $pictureFile;

        if ($pictureFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->pictureUpdatedAt = new \DateTime('now');
        }
    }

    /**
     * Get pictureFile
     *
     * @return \File 
     */
    public function getPictureFile()
    {
        return $this->pictureFile;
    }

    /**
     * Set pictureName
     *
     * @param string $pictureName
     * @return User
     */
    public function setPictureName($pictureName)
    {
        $this->pictureName = $pictureName;

        return $this;
    }

    /**
     * Get pictureName
     *
     * @return string 
     */
    public function getPictureName()
    {
        return $this->pictureName;
    }

    /**
     * Set pictureUpdatedAt
     *
     * @param \DateTime $pictureUpdatedAt
     * @return User
     */
    public function setPictureUpdatedAt($pictureUpdatedAt)
    {
        $this->pictureUpdatedAt = $pictureUpdatedAt;

        return $this;
    }

    /**
     * Get pictureUpdatedAt
     *
     * @return \DateTime 
     */
    public function getPictureUpdatedAt()
    {
        return $this->pictureUpdatedAt;
    }
}
