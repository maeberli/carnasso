<?php

namespace Application\Model\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;

/**
 * @Entity
 * @Table(name="Event")
 *
 * @author marco.aeberli
 */
class Event {

    /** @Id @Column(type="integer") @GeneratedValue * */
    protected $id;

    /** @Column(type="string") * */
    protected $title;

    /** @Column(type="string") * */
    protected $description;

    /** @Column(type="date") * */
    protected $date;

    /** @Column(type="time") * */
    protected $startTime;

    /** @Column(type="time") * */
    protected $endTime;

    /** @Column(type="string") * */
    protected $location;

    /**
     * @ManyToOne(targetEntity="CarnivalYear",inversedBy="getEvents")
     */
    protected $carnivalYear;
    
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
    public function getTitle() {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title) {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description) {
        $this->description = $description;
    }

    /**
     * @return DateTime 
     */
    public function getDate() {
        return $this->date;
    }

    /**
     * @param DateTime $date
     */
    public function setDate($date) {
        $this->date = $date;
    }

    /**
     * @return DateTime 
     */
    public function getStartTime() {
        return $this->startTime;
    }

    /**
     * @param DateTime $startTime
     */
    public function setStartTime($startTime) {
        $this->startTime = $startTime;
    }

    /**
     * @return DateTime 
     */
    public function getEndTime() {
        return $this->endTime;
    }

    /**
     * @param DateTime $endTime
     */
    public function setEndTime($endTime) {
        $this->endTime = $endTime;
    }

    /**
     * @return string
     */
    public function getLocation() {
        return $this->location;
    }

    /**
     * @param string $location
     */
    public function setLocation($location) {
        $this->location = $location;
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
}

?>
