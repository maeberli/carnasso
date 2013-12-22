<?php

namespace Application\Model\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="Member")
 *
 * @author marco.aeberli
 */
class Member {

    /** @ORM\Id @ORM\Column(type="integer") @ORM\GeneratedValue * */
    protected $id;

    /** @ORM\Column(type="string") * */
    protected $prename;

    /** @ORM\Column(type="string") * */
    protected $name;

    /** @ORM\Column(type="string") * */
    protected $imagePath;
    
    /** @ORM\Column(type="string") * */
    protected $responsabilities;
    
    /** @ORM\ManyToOne(targetEntity="CarnivalYear",inversedBy="getMembers") * */
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
    public function getPrename() {
        return $this->prename;
    }

    /**
     * @param string $prename
     */
    public function setPrename($prename) {
        $this->prename = $prename;
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getImagePath() {
        return $this->imagePath;
    }

    /**
     * @param string $imagePath
     */
    public function setImagePath($imagePath) {
        $this->imagePath = $imagePath;
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

    /**
     * @return ArrayCollection
     */
    public function getCarnivalYear()
    {
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
