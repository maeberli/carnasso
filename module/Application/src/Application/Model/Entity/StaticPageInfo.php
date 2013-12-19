<?php

namespace Application\Model\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="StaticPageInfo", uniqueConstraints={@ORM\UniqueConstraint(name="pagename_unique", columns={"pagename"})})
 *
 * @author marco.aeberli
 */
class StaticPageInfo {
    
    const ABOUTUS_ID = "ABOUT_ASSOCIATION";
    const JOINUS_ID = "JOINUS";

    /** @ORM\Id @ORM\Column(type="integer") @ORM\GeneratedValue * */
    protected $id;
    
    /** @ORM\Column(type="string") * */
    protected $pagename;

    /** @ORM\Column(type="string") * */
    protected $staticText;
    
    public function __construct() {
    }

    /**
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id) {
        $this->id = $id;
    }
    
    /**
     * @return string
     */
    public function getPagename() {
        return $this->pagename;
    }
    
    /**
     * @param string $pagename
     */
    public function setPagename($pagename) {
        $this->pagename = $pagename;
    }
    
    /**
     * @return string
     */
    public function getStaticText() {
        return $this->staticText;
    }
    
    /**
     * @param string $staticText
     */
    public function setStaticText($staticText) {
        $this->staticText = $staticText;
    }
}

?>
