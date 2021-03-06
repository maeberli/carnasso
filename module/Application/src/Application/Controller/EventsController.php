<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\View\Model\ViewModel;
use Application\Model\Entity\Event;
use Application\Form\AddEventForm;
use Application\Form\EventFilter;

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
        // Authentification
        if (! $this->auth()->hasIdentity() ){
            return $this->redirect()->toRoute('admin', array('action' => 'login'));
        }
        
        // Getting last year
        $carinvalYearRepository = $this->entity()->getCarnivalYearRepository();
        $currentCarnivalYear = $carinvalYearRepository->findOneBy(array('year' => $this->getCurrentCarnivalYear()->getYear()), array('year' => 'DESC'));
        
        // Event form
        $addForm = new AddEventForm();

        // Setting view
        return new ViewModel(array(
            'menuParams' => $this->getMenuParameters(),
            'carnivalYear' => $currentCarnivalYear,
            'addForm' => $addForm,
            'base_url' => preg_replace('#manage.*#', '', $this->getRequest()->getUri()),
        ));
    }

    public function addAction() {
        // Authentification
        if (! $this->auth()->hasIdentity() ){
            return $this->redirect()->toRoute('admin', array('action' => 'login'));
        }
        
        $request = $this->getRequest();
        $form = new AddEventForm();
        
        // Creating new Event entity
        $event = new Event;
        $this->setEventWithRequest($event, $request);
        $event->setCarnivalYear($this->getCurrentCarnivalYear());
        
        if ($request->isPost())
        {
            $form->setInputFilter(new EventFilter());
            $form->setData($request->getPost());
            
            if ($form->isValid())
            {
                // Inserting event to database
                $this->entity()->getEntityManager()->persist($event);
                $this->entity()->getEntityManager()->flush();
            }
                
            // Setting view and return partial view to be added in manage
            $this->layout('layout/empty');
            return new ViewModel(array(
                'event' => $event,
            ));
        }
    }
    
    public function geteditformAction() {
        // Authentification
        if (! $this->auth()->hasIdentity() ){
            return $this->redirect()->toRoute('admin', array('action' => 'login'));
        }
        
        // Getting event
        $eventRepository = $this->entity()->getEventRepository();
        // TODO Control ID
        $event = $eventRepository->findOneBy(array('id' => $this->params()->fromRoute('id', 0)));
        
        // Event form
        $addForm = new AddEventForm();
        
        $addForm->get('day')->setValue($event->getDate()->format('j'));
        $addForm->get('day')->setAttribute('id', $addForm->get('day')->getAttribute('id').'-'.$event->getId());
        
        $addForm->get('month')->setValue($event->getDate()->format('m'));
        $addForm->get('month')->setAttribute('id', $addForm->get('month')->getAttribute('id').'-'.$event->getId());
        
        $addForm->get('start_time')->setValue($event->getStartTime()->format('H:i:s'));
        $addForm->get('start_time')->setAttribute('id', $addForm->get('start_time')->getAttribute('id').'-'.$event->getId());
        $addForm->get('stop_time')->setValue($event->getEndTime()->format('H:i:s'));
        $addForm->get('stop_time')->setAttribute('id', $addForm->get('stop_time')->getAttribute('id').'-'.$event->getId());
        
        $addForm->get('title')->setValue($event->getTitle());
        $addForm->get('title')->setAttribute('id', $addForm->get('title')->getAttribute('id').'-'.$event->getId());
        $addForm->get('description')->setValue($event->getDescription());
        $addForm->get('description')->setAttribute('id', $addForm->get('description')->getAttribute('id').'-'.$event->getId());
        
        $addForm->get('saveButton')->setAttribute('data-id', $event->getId());
        
        // Setting view and return partial view to be added in manage
        $this->layout('layout/empty');
        return new ViewModel(array(
            'event' => $event,
            'addForm' => $addForm,
        ));
    }

    public function editAction() {
        // Authentification
        if (! $this->auth()->hasIdentity() ){
            return $this->redirect()->toRoute('admin', array('action' => 'login'));
        }
        
        // Getting event
        $eventRepository = $this->entity()->getEventRepository();
        // TODO Control ID
        $event = $eventRepository->findOneBy(array('id' => $this->params()->fromRoute('id', 0)));
        
        $request = $this->getRequest();
        $this->setEventWithRequest($event, $request);
        
        // Updating event to database
        $this->entity()->getEntityManager()->persist($event);
        $this->entity()->getEntityManager()->flush();
        
        // Setting view and return partial view to be added in manage
        $this->layout('layout/empty');
        return new ViewModel(array(
            'event' => $event,
        ));
    }

    public function deleteAction() {
        // Authentification
        if (! $this->auth()->hasIdentity() ){
            return $this->redirect()->toRoute('admin', array('action' => 'login'));
        }
        
        // Getting event
        $eventRepository = $this->entity()->getEventRepository();
        // TODO Control ID
        $event = $eventRepository->findOneBy(array('id' => $this->params()->fromRoute('id', 0)));
        // Delete event from database
        $this->entity()->getEntityManager()->remove($event);
        $this->entity()->getEntityManager()->flush();
    }
    
    public function setEventWithRequest($event, $request)
    {
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
    }

}
