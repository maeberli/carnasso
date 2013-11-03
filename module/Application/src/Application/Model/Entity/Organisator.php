<?php

namespace Application\Model\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;

/**
 * @Entity
 * @Table(name="Organisator")
 *
 * @author marco.aeberli
 */
class Organisator {

    /** @Id @Column(type="integer") @GeneratedValue * */
    protected $id;
    
    /** @Column(type="string") * */
    protected $responsabilities;
    
    /**
     * @ManyToOne(targetEntity="CarnivalYear",inversedBy="getOrganisators")
     */
    protected $carnivalYear;
    
    /**
     * @ManyToOne(targetEntity="Member",inversedBy="getOrganisators")
     */
    protected $member;
    
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
     * @return CarnivalYear
     */
    public function getCarnivalYear() {
        return $this->carnivalYear;
    }
    
    /**
     * @param CarnivalYear $carnivalYear
     */
    public function setCarnivalYear($carnivalYear) {
        $this->carnivalYear = $carnivalYear;
    }
    
    /**
     * @return Member
     */
    public function getMember() {
        return $this->member;
    }
    
    /**
     * @param Member $member
     */
    public function setMember($member) {
        $this->member = $member;
    }
    
    /**
     * @return string
     */
    public function getResponsabilites() {
        return $this->responsabilities;
    }
    
    /**
     * @return string $responsabilities
     */
    public function setResponsabilities($responsabilities) {
        $this->responsabilities = $responsabilities;
    }
    
}

?>
