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
            'attributes' => array(
                'type' => 'text',
                'value' => 'Name',
                'id' => 'name',
                'onClick' => 'if(this.value=="Name")this.value = ""',
                'onBlur' => 'if(this.value=="")this.value="Name"',
            ),
        ));

        $this->add(array(
            'name' => 'prename',
            'attributes' => array(
                'type' => 'text',
                'value' => 'Prename',
                'id' => 'prename',
                'onClick' => 'if(this.value=="Prename")this.value = ""',
                'onBlur' => 'if(this.value=="")this.value="Prename"',
            ),
        ));

        $this->add(array(
            'name' => 'description',
            'attributes' => array(
                'type' => 'textarea',
                'value' => 'Description',
                'id' => 'description',
                'onClick' => 'if(this.value=="Description")this.value = ""',
                'onBlur' => 'if(this.value=="")this.value="Description"',
            ),
        ));

        $this->add(array(
            'name' => 'append',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Append',
                'id' => 'addButton',
            ),
        ));
    }

}