<?php
namespace Application\Form;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;

use Application\Model\Entity\User;

class LoginFilter extends InputFilter
{
    public function __construct($userRepository)
    {
        $this->add(array(
            'name'     => 'username',
            'required' => true,
            'filters'  => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name'    => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min'      => 1,
                        'max'      => 100,
                    ),
                ),
                array(
                    'name'                => 'DoctrineModule\Validator\ObjectExists',
                    'options' => array(
                        'object_repository' => $userRepository,
                        'fields'            => 'usrName'
                    ),
                ),
            ), 
        ));
    
        $this->add(array(
            'name'     => 'password',
            'required' => true,
            'filters'  => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name'    => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min'      => 6,
                        'max'      => 12,
                    ),
                ),
            ),
        ));                
    }
}
