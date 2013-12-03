<?php
namespace Application\Form;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;

use Application\Model\Entity\CarnivalYear;

class CarnivalYearEditFilter extends InputFilter
{
    public function __construct($repository)
    {
        $this->add(array(
            'name'     => 'backgroundImPathNew',
            'required' => false,
            'validators' => array(
                new \Zend\Validator\File\UploadFile(),
            ),
        ));
        $this->add(array(
            'name'     => 'flyerImgPathNew',
            'required' => false,
            'validators' => array(
                new \Zend\Validator\File\UploadFile(),
            ),
        ));
    }
}
