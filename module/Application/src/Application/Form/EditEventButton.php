<?php

namespace Application\Form;

use Zend\Form\Form;

class EditEventButton extends Form {

    public function __construct($options = null) {
        parent::__construct($options);
        $this->setName('edit_form');
        $this->setAttribute('method', 'post');

        $this->add(array(
            'name' => 'edit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Edit',
                'id' => 'editButton',
            ),
        ));
    }

}