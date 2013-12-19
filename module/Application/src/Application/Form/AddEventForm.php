<?php

namespace Application\Form;

use Zend\Form\Form;

class AddEventForm extends Form {

    public function __construct($options = null) {
        parent::__construct($options);

        // Set german as main language
        setlocale(LC_TIME, 'deu_deu');
        
        $this->setName('add_form');
        $this->setAttribute('method', 'post');
        
        $days = array();
        for($i = 1;$i<32;$i++)
            $days[$i] = $i;
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'day',
            'options' => array(
                'value_options' => $days,
            ),
            'attributes' => array(
                'value' => '01', //set selected to '0'
                'id' => 'days',
                'class' => 'form-control',
            )
        ));
        
        $months = array();
        for($i = 1;$i<13;$i++)
            $months[$i] = utf8_encode(strftime("%B", mktime(0,0,0,$i)));
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'month',
            'options' => array(
                'value_options' => $months,
            ),
            'attributes' => array(
                'value' => '01',
                'id' => 'month',
                'class' => 'form-control',
            )
        ));
        
        $times = array();
        for($hour = 0;$hour<24;$hour++)
        {
            for($minutes = 0;$minutes<=45;$minutes+=15)
            {
                $times[date("H:i", mktime($hour,$minutes)).":00"] = date("H:i", mktime($hour,$minutes));
            }
        }
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'start_time',
            'options' => array(
                'value_options' => $times,
            ),
            'attributes' => array(
                'value' => '00:00:00',
                'id' => 'start_time',
                'class' => 'form-control',
            )
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'stop_time',
            'options' => array(
                'value_options' => $times,
            ),
            'attributes' => array(
                'value' => '00:00:00',
                'id' => 'stop_time',
                'class' => 'form-control',
            )
        ));

        $this->add(array(
            'name' => 'title',
            'attributes' => array(
                'type' => 'text',
                'value' => '',
                'id' => 'title',
                'placeholder' => 'Title',
                'class' => 'form-control',
            ),
        ));

        $this->add(array(
            'name' => 'description',
            'attributes' => array(
                'type' => 'textarea',
                'value' => '',
                'id' => 'description',
                'placeholder' => 'Description',
                'class' => 'form-control',
            ),
        ));
        
        $this->add(array(
            'name' => 'postButton',
            'attributes' => array(
                'type' => 'button',
                'value' => 'Append',
                'class' => 'btn btn-default insertButton postButton',
            ),
        ));
        
        $this->add(array(
            'name' => 'saveButton',
            'attributes' => array(
                'type' => 'button',
                'value' => 'Save',
                'class' => 'btn btn-default insertButton saveButton',
            ),
        ));
    }

}