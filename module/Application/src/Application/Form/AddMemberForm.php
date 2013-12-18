<?php

namespace Application\Form;

use Zend\Form\Form;

class AddMemberForm extends Form {

    public function __construct($options = null) {
        parent::__construct($options);

        // Set german as main language
        setlocale(LC_TIME, 'deu_deu');
        
        $this->setName('add_form');
        $this->setAttribute('method', 'post');
        
        $this->add(array(
            'name' => 'name',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'id' => 'name',
                'placeholder' => 'Name',
                'required' => 'required',
                'class' => 'form-control',
            ),
        ));

        $this->add(array(
            'name' => 'prename',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'id' => 'prename',
                'placeholder' => 'Prename',
                'required' => 'required',
                'class' => 'form-control',
            ),
        ));

        $this->add(array(
            'name' => 'responsabilities',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array( 
                'required' => 'required',
                'id' => 'responsabilities',
                'placeholder' => 'Responsabilities',
                'class' => 'form-control',
            ),
        ));
        
        
        $this->add(array(
            'name' => 'postButton',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'value' => 'Save',
                'class' => 'btn btn-sm',
            ),
        ));

        $this->add(array(
            'name' => 'append',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'value' => 'Append',
                'id' => 'addButton',
            ),
        ));
    }
}
