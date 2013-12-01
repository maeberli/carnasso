<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Model\Entity\Event;
use Application\Form\EditForm;
use Application\Form\DeleteForm;

class EventsController extends AbstractCarnassoController {

    public function indexAction() {
        // Getting last year
        $currentCarnivalYear = $this->getCurrentCarnivalYear();

        // Setting view
        return new ViewModel(array(
            'menuParams' => $this->getMenuParameters(),
            'eventList' => $currentCarnivalYear->getEvents(),
        ));
    }

    public function manageAction() {
        // Getting last year
        $carinvalYearRepository = $this->entity()->getCarnivalYearRepository();
        $currentCarnivalYear = $carinvalYearRepository->findOneBy(array('year' => '2012'), array('year' => 'DESC'));
        
        // Management buttons
        $editForm = new EditForm();
        $deleteForm = new DeleteForm();

        // Setting view
        return new ViewModel(array(
            'menuParams' => $this->getMenuParameters(),
            'eventList' => $currentCarnivalYear->getEvents(),
            'editForm' => $editForm,
            'deleteForm' => $deleteForm,
        ));
    }

    public function addAction() {
        
    }

    public function editAction() {
        
    }

    public function deleteAction() {
        
    }

}
