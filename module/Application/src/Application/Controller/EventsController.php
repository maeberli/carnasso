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
use Application\Form\EditEventButton;
use Application\Form\DeleteEventButton;
use Application\Form\AddEventForm;

class EventsController extends AbstractCarnassoController {

    public function indexAction() {
        
        $this->setBackgroundImage();
        
        // Getting last year
        $currentCarnivalYear = $this->getCurrentCarnivalYear();

        // Setting view
        return new ViewModel(array(
            'menuParams' => $this->getMenuParameters(),
            'eventList' => $currentCarnivalYear->getEvents(),
        ));
    }

    public function manageAction() {
        // Authentification
        if (! $this->auth()->hasIdentity() ){
            return $this->redirect()->toRoute('admin', array('action' => 'login'));
        }
        
        $this->setBackgroundImage();
        
        // Getting last year
        $carinvalYearRepository = $this->entity()->getCarnivalYearRepository();
        $currentCarnivalYear = $carinvalYearRepository->findOneBy(array('year' => $this->getCurrentCarnivalYear()->getYear()), array('year' => 'DESC'));
        
        // Management buttons
        $editForm = new EditEventButton();
        $deleteForm = new DeleteEventButton();
        $addForm = new AddEventForm();

        // Setting view
        return new ViewModel(array(
            'menuParams' => $this->getMenuParameters(),
            'eventList' => $currentCarnivalYear->getEvents(),
            'addForm' => $addForm,
            'editForm' => $editForm,
            'deleteForm' => $deleteForm,
        ));
    }

    public function addAction() {
        // Authentification
        if (! $this->auth()->hasIdentity() ){
            return $this->redirect()->toRoute('admin', array('action' => 'login'));
        }
        
        $request = $this->getRequest();
        // Creating new Event entity
        $event = new Event;
        
        $event->setTitle($request->getPost('title'));
        $date = new \DateTime();
        
        $date->setDate($this->getCurrentCarnivalYear()->getYear(), $request->getPost('month'), $request->getPost('day'));
        $event->setDate($date);
        
        $event->setCarnivalYear($this->getCurrentCarnivalYear());
        
        $start = explode(":",$request->getPost('start_time'));
        $startTime = new \DateTime();
        $startTime->setTime($start[0], $start[1]);
        $event->setStartTime($startTime);
        
        $stop = explode(":",$request->getPost('stop_time'));
        $stopTime = new \DateTime();
        $stopTime->setTime($stop[0], $stop[1]);
        $event->setEndTime($stopTime);
        
        $event->setDescription($request->getPost('description'));
        $event->setLocation("");
        
        // Inserting event to database
        $this->entity()->getEntityManager()->persist($event);
        $this->entity()->getEntityManager()->flush();
    }

    public function editAction() {
        // Authentification
        if (! $this->auth()->hasIdentity() ){
            return $this->redirect()->toRoute('admin', array('action' => 'login'));
        }
        // Getting event
        $eventRepository = $this->entity()->getEventRepository();
        $event = $eventRepository->findOneBy(array('id' => $this->params()->fromRoute('id', 0)));
        
        $event->setTitle($request->getPost('title'));
        $date = new \DateTime();
        
        $date->setDate($this->getCurrentCarnivalYear()->getYear(), $request->getPost('month'), $request->getPost('day'));
        $event->setDate($date);
        
        $start = explode(":",$request->getPost('start_time'));
        $startTime = new \DateTime();
        $startTime->setTime($start[0], $start[1]);
        $event->setStartTime($startTime);
        
        $stop = explode(":",$request->getPost('stop_time'));
        $stopTime = new \DateTime();
        $stopTime->setTime($stop[0], $stop[1]);
        $event->setEndTime($stopTime);
        
        $event->setDescription($request->getPost('description'));
        $event->setLocation("");
        
        // Updating event to database
        $this->entity()->getEntityManager()->persist($event);
        $this->entity()->getEntityManager()->flush();
    }

    public function deleteAction() {
        // Authentification
        if (! $this->auth()->hasIdentity() ){
            return $this->redirect()->toRoute('admin', array('action' => 'login'));
        }
        // Getting event
        $eventRepository = $this->entity()->getEventRepository();
        $event = $eventRepository->findOneBy(array('id' => $this->params()->fromRoute('id', 0)));
        // Delete event from database
        $this->entity()->getEntityManager()->remove($event);
        $this->entity()->getEntityManager()->flush();
    }

}
