<?php

namespace AppBundle\Entity;
use Symfony\Component\Serializer\Annotation\Groups;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

class User extends BaseUser
{

    protected $id;
    protected $nickname;
    protected $firstname;
    protected $lastname;
    protected $image;
    
    public function __construct()
    {
        parent::__construct();
        // your own logic
    }
    /**
     * Get id
     *
     * @return integer 
     * @Groups({"edit"})
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nickname
     *
     * @param string $nickname
     * @return User
     */
    public function setNickname($nickname)
    {
        $this->nickname = $nickname;

        return $this;
    }

    /**
     * Get nickname
     *
     * @return string 
     * @Groups({"edit"})
     */
    public function getNickname()
    {
        return $this->nickname;
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
     * @Groups({"edit"})
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
     * @Groups({"edit"})
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set image
     *
     * @param string $image
     * @return User
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string 
     * @Groups({"edit"})
     */
    public function getImage()
    {
        return $this->image;
    }

    public function __toString()
    {
        return $this->getNickname();
    }

}
