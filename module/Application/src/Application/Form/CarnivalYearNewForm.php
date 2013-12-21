<?php
namespace Application\Form;

use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\Form\Form;


class CarnivalYearNewForm extends Form
{
    const MAX_YEARS_SHOWNED = 5;
    
    private $carnivalRepository;
    
    public function __construct(ObjectManager $objectManager,
        \Doctrine\ORM\EntityRepository $carnivalRepository)
    {
        parent::__construct('index');
        
        $this->carnivalRepository = $carnivalRepository;
        
        // Setting the Doctrine hydrator allows to populate the a from
        // directly from object and in the oposite sense too.
        $this->setHydrator(new DoctrineHydrator($objectManager, 'Application\Model\Entity\CarnivalYear'));
        
        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype','multipart/form-data');
        
        $this->add(array(
            'name' => 'year',
            'type' => 'Zend\Form\Element\Select',
            'options' => array(
                'value_options' => $this->getYearSelectOptions(),
            ),
            'attributes' => array(
                'class' => 'form-control',
            )
        ));
        
        $this->add(array(
            'name' => 'backgroundImgPath',
            'attributes' => array(
                'type'  => 'file',
            ),
        ));
        
        $this->add(array(
            'name' => 'flyerImgPath',
            'attributes' => array(
                'type'  => 'file',
            ),
        ));
    
        $this->add(array(
            'name' => 'savebutton',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Speichern',
                'id' => 'savebutton',
                'class' => 'btn btn-default',
            ),
        ));
    }
    
    
    public function getYearSelectOptions()
    {
        $carnivalYears = $this->carnivalRepository->findAll();
        
        // get all the existing years from the DB
        $existingYears = array();
        foreach ($carnivalYears as $year) {
            $existingYears[$year->getYear()] = $year->getYear();
        }
        
        // Calulcate the next N years.
        $possibleYears  = array();
        for( $i = 0; $i < self::MAX_YEARS_SHOWNED; ++$i) {
            $year = date('Y', strtotime('+'.$i.' year'));
            $possibleYears[$year] = $year;
        }

        // return only the diff beetween the two sets, to don't allow
        // duplicates.
        return array_diff($possibleYears, $existingYears);
    }
}
