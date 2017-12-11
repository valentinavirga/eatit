<?php

namespace AppBundle\Entity;
use Symfony\Component\Serializer\Annotation\Groups;

class Category
{

    protected $id;
    protected $name;

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
     * Set name
     *
     * @param string $name
     * @return Category
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
     * @Groups({"edit"})
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * @return string 
     */
    public function __toString()
    {
        return $this->getName();
    }
    
}
