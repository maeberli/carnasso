<?php
namespace Application\Form;

use Zend\Form\Form;


class CarnivalYearDeleteForm extends Form
{
    
    public function __construct()
    {
        parent::__construct('index');
        
        $this->setAttribute('method', 'post');

    
        $this->add(array(
            'name' => 'cancelbutton',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Nein',
                'id' => 'cancelbutton',
            ),
        ));

        $this->add(array(
            'name' => 'confirmbutton',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Ja',
                'id' => 'confirmbutton',
            ),
        ));
    }
}
