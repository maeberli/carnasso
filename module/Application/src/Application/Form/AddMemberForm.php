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
        $this->setAttribute('enctype','multipart/form-data');
        
        $this->add(array(
            'name' => 'memberPhoto',
            'attributes' => array(
                'type'  => 'file',
            ),
            'options' => array(
                'label' => 'ersetzen',
            ),
        ));
		
        $this->add(array(
            'name' => 'name',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'Name',
                'required' => 'required',
                'class' => 'form-control',
            ),
        ));

        $this->add(array(
            'name' => 'prename',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
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
                'placeholder' => 'Responsabilities',
                'class' => 'form-control',
            ),
        ));
        
        
        $this->add(array(
            'name' => 'appendButton',
            'attributes' => array(
                'type'  => 'button',
                'value' => 'Hinzufügen',
                'class' => 'btn btn-sm appendButton',
            ),
        ));

        $this->add(array(
            'name' => 'saveButton', 
            'attributes' => array(
                'type'  => 'button',
                'value' => 'Speichern',
                'class' => 'btn btn-sm saveButton',
            ),
        ));
    }
}
