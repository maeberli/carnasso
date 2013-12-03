<?php

namespace Application\Model\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="CarnivalYear")
 *
 * @author marco.aeberli
 */
class CarnivalYear {

    /** @ORM\Id @ORM\Column(type="integer") @ORM\GeneratedValue * */
    protected $id;
    
    /** @ORM\Column(type="integer") * */
    protected $year;
        
    /** @ORM\Column(type="string") * */
    protected $backgroundImgPath;

    /** @ORM\Column(type="string") * */
    protected $flyerImgPath;

    /**
     * @ORM\OneToMany(targetEntity="Organisator",mappedBy="carnivalYear")
     * @var Organisator[]
     */
    protected $organisators;
    
    /**
     * @ORM\OneToMany(targetEntity="Event",mappedBy="carnivalYear")
     * @var Event[]
     */
    protected $events;
    
    public function __construct() {
        $this->organisators = new ArrayCollection();
        $this->events = new ArrayCollection();
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
     * @return int
     */
    public function getYear() {
        return $this->year;
    }
    
    /**
     * @param int $carnevalYear
     */
    public function setYear($year) {
        $this->year = $year;
    }
    
    /**
     * @return string
     */
    public function getBackgroundImgPath() {
        return $this->backgroundImgPath;
    }
    
    /**
     * @param string $backgroundImgPath
     */
    public function setBackgroundImgPath($backgroundImgPath) {
        $this->backgroundImgPath = $backgroundImgPath;
    }
    
    /**
     * @return string
     */
    public function getFlyerImgPath() {
        return $this->flyerImgPath;
    }
    
    /**
     * @param string $flyerImgPath
     */
    public function setFlyerImgPath($flyerImgPath) {
        $this->flyerImgPath = $flyerImgPath;
    }
    
    /**
     * @return ArrayCollection
     */
    public function getOrganisators() {
        return $this->organisators;
    }
    
    /**
     * @return ArrayCollection
     */
    public function getEvents() {
        return $this->events;
    }
}

?>
