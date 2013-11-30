<?php

namespace Application\Model\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping as ORM;

use Zend\Form\Annotation;

/**
 * @ORM\Table(name="User")
 * @ORM\Entity
 * @Annotation\Name("user")
 * @Annotation\Hydrator("Zend\Stdlib\Hydrator\ClassMethods")
 */
class User {
        
    /**
     * @ORM\Column(name="usr_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Annotation\Exclude()
     */
    protected $id;
    
    /**
     * @ORM\Column(name="usr_name", type="string", length=100, nullable=false)
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":30}})
     * @Annotation\Validator({"name":"Regex", "options":{"pattern":"/^[a-zA-Z][a-zA-Z0-9_-]{0,24}$/"}})
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"Username:"})         
     */
    protected $usrName;
    
    /**
     * @ORM\Column(name="usr_password", type="string", length=100, nullable=false)
     * @Annotation\Attributes({"type":"password"})
     * @Annotation\Options({"label":"Password:"})        
     */
    protected $usrPassword;
    
    public function __construct()
    {
        $this->usrRegistrationDate = new \DateTime();
    }
    
    /**
     * @param string $usrName
     * @return Users
     */
    public function setUsrName($usrName)
    {
        $this->usrName = $usrName;
        return $this;
    }
    
    /**
     * @return string 
     */
    public function getUsrName()
    {
        return $this->usrName;
    }
    
    /**
     * @param string $usrPassword
     * @return Users
     */
    public function setUsrPassword($usrPassword)
    {
        $this->usrPassword = $usrPassword;
        return $this;
    }
    
    /**
     * @return string
     */
    public function getUsrPassword()
    {
        return $this->usrPassword;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}
