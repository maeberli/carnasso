<?php
namespace Application\Form;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;

class CarnivalYearNewFilter extends InputFilter
{
    public function __construct($repository)
    {
        $this->add(array(
            'name'      => 'year',
            'required'  => true,
        ));
        
        $this->add(array(
            'name'       => 'backgroundImgPath',
            'required'   => true,
            'validators' => array(
                new \Zend\Validator\File\UploadFile(),
            ),
        ));
        $this->add(array(
            'name'       => 'flyerImgPath',
            'required'   => true,
            'validators' => array(
                new \Zend\Validator\File\UploadFile(),
            ),
        ));
    }
}

