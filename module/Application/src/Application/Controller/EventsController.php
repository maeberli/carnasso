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

class EventsController extends AbstractActionController {

    public function indexAction() {
        // Getting last year
        $carinvalYearRepository = $this->entity()->getCarnivalYearRepository();
        // TODO remove array('year' => '2012')
        $lastCarnivalYear = $carinvalYearRepository->findOneBy(array('year' => '2012'), array('year' => 'DESC'));

        // Setting view
        return new ViewModel(array(
            'eventList' => $lastCarnivalYear->getEvents(),
        ));
    }

    public function manageAction() {
        
    }

    public function addAction() {
        
    }

    public function editAction() {
        
    }

    public function deleteAction() {
        
    }

}
