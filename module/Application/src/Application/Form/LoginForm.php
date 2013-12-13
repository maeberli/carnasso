<?php
namespace Application\Form;

use Zend\Form\Form;


class LoginForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('admin');
        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'username',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Benutzername',
            ),
        ));
        $this->add(array(
            'name' => 'password',
            'attributes' => array(
                'type'  => 'password',
            ),
            'options' => array(
                'label' => 'Passwort',
            ),
        ));
    
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Anmelden',
                'id' => 'submitbutton',
            ),
        )); 
    }
}
