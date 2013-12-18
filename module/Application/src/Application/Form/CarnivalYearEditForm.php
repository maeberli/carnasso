<?php
namespace Application\Form;

use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\Form\Form;


class CarnivalYearEditForm extends Form
{
    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('index');
        
        $this->setHydrator(new DoctrineHydrator($objectManager, 'Application\Model\Entity\CarnivalYear'));
        
        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype','multipart/form-data');
        
        $this->add(array(
            'name' => 'backgroundImgPathNew',
            'attributes' => array(
                'type'  => 'file',
            ),
            'options' => array(
                'label' => 'ersetzen',
            ),
        ));
        
        $this->add(array(
            'name' => 'flyerImgPathNew',
            'attributes' => array(
                'type'  => 'file',
            ),
            'options' => array(
                'label' => 'ersetzen',
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
}
