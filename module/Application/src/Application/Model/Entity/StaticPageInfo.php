<?php

namespace Application\Model\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="StaticPageInfo")
 *
 * @author marco.aeberli
 */
class StaticPageInfo {

    /** @ORM\Id @ORM\Column(type="integer") @ORM\GeneratedValue * */
    protected $id;

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
