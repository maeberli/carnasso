<?php

namespace Application\Model\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;

/**
 * @Entity
 * @Table(name="StaticPageInfo")
 *
 * @author marco.aeberli
 */
class StaticPageInfo {

    /** @Id @Column(type="integer") @GeneratedValue * */
    protected $id;

    /** @Column(type="string") * */
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
