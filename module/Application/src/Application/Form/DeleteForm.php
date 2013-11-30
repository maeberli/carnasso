<?php

namespace Application\Form;

use Zend\Form\Form;

class DeleteForm extends Form {

    public function __construct($options = null) {
        parent::__construct($options);
        $this->setName('edit_form');
        $this->setAttribute('method', 'post');

        $this->add(array(
            'name' => 'delete',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Delete',
                'id' => 'editButton',
            ),
        ));
    }

}