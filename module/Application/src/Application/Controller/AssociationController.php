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
use Application\Model\Entity\Organisator;
use Application\Model\Entity\Member;
use Application\Form\EditEventButton;
use Application\Form\DeleteEventButton;
use Application\Form\AddMemberForm;

class AssociationController extends AbstractCarnassoController
{
    const MEMBERIMGPATH = "/img/members/";
	
    public function indexAction()
    {   
        // Getting last year
        $currentCarnivalYear = $this->getCurrentCarnivalYear();

        // Setting view
        return new ViewModel(array(
            'menuParams' => $this->getMenuParameters(),
            'organisatorList' => $currentCarnivalYear->getOrganisators(),
			'imagePath' => $this->getBasePath().self::MEMBERIMGPATH,
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
        
        // Management buttons
        $addForm = new AddMemberForm();

        // Setting view
        return new ViewModel(array(
            'menuParams' => $this->getMenuParameters(),
            'organisatorList' => $currentCarnivalYear->getOrganisators(),
			'imagePath' => $this->getBasePath().self::MEMBERIMGPATH,
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
        // Creating new Member entity
        $member = new Member;
		$organisator = new Organisator;
        
		$this->setOrganisatorWithRequest($member, $organisator, $request);		
        
        // Inserting member to database
        $this->entity()->getEntityManager()->persist($member);
        $this->entity()->getEntityManager()->persist($organisator);
        $this->entity()->getEntityManager()->flush();
		
		// Setting view and return partial view to be added in manage
        $this->layout('layout/empty');
        return new ViewModel(array(
            'organisator' => $organisator,
        ));
    }
	
    public function geteditformAction() {
        // Authentification
        if (! $this->auth()->hasIdentity() ){
            return $this->redirect()->toRoute('admin', array('action' => 'login'));
        }
        
        // Getting member
        $memerRepository = $this->entity()->getMemberRepository();
        // TODO Control ID
        $member = $memerRepository->findOneBy(array('id' => $this->params()->fromRoute('id', 0)));
        
        // Member form
        $addForm = new AddMemberForm();

		$addForm->get('imagePath')->setValue($member->getImagePath());
		$addForm->get('imagePath')->setAttribute('id',$addForm->get('imagePath')->getAttribute('id').'-'.$member->getId());
		
		$addForm->get('prename')->setValue($member->getPrename());
		$addForm->get('prename')->setAttribute('id',$addForm->get('prename')->getAttribute('id').'-'.$member->getId());
		$addForm->get('name')->setValue($member->getName());
		$addForm->get('name')->setAttribute('id',$addForm->get('name')->getAttribute('id').'-'.$member->getId());
		
		$addForm->get('responsabilities')->setValue($organisator->getResponsabilites());
		$addForm->get('responsabilities')->setAttribute('id',$addForm->get('responsabilities')->getAttribute('id').'-'.$organisator->getId());
		
        // Setting view and return partial view to be added in manage
        $this->layout('layout/empty');
        return new ViewModel(array(
            'organisator' => $organisator,
            'addForm' => $addForm,
        ));
    }

    public function editAction() {
		// Authentification
        if (! $this->auth()->hasIdentity() ){
            return $this->redirect()->toRoute('admin', array('action' => 'login'));
        }
		
        // Getting member
        $memberRepository = $this->entity()->getMemberRepository();
        // TODO Control ID
        $member = $memberRepository->findOneBy(array('id' => $this->params()->fromRoute('id', 0)));
        
        // Getting organisator
		$organisatorRepository = $this->entity()->getOrganisatorRepository();
        // TODO Control ID
        $organisator = $organisatorRepository->findOneBy(array('id' => $this->params()->fromRoute('id', 0)));
        
        $request = $this->getRequest();
		
		$this->setOrganisatorWithRequest($member, $organisator, $request);		
        
        // Updating member to database
        $this->entity()->getEntityManager()->persist($member);
        $this->entity()->getEntityManager()->persist($organisator);
        $this->entity()->getEntityManager()->flush();
		
        // Setting view and return partial view to be added in manage
        $this->layout('layout/empty');
        return new ViewModel(array(
            'organisator' => $organisator,
        ));
    }

    public function deleteAction() {
		// Authentification
        if (! $this->auth()->hasIdentity() ){
            return $this->redirect()->toRoute('admin', array('action' => 'login'));
        }
		
        // Getting member
        $memberRepository = $this->entity()->getMemberRepository();
        // TODO Control ID
        $member = $memberRepository->findOneBy(array('id' => $this->params()->fromRoute('id', 0)));
        
        // Getting organisator
        $organisatorRepository = $this->entity()->getOrganisatorRepository();
        // TODO Control ID
        $organisator = $organisatorRepository->findOneBy(array('id' => $this->params()->fromRoute('id', 0)));
        
		// Delete member from database
        $this->entity()->getEntityManager()->remove($member);
        $this->entity()->getEntityManager()->remove($organisator);
        $this->entity()->getEntityManager()->flush();
    }
	
    public function setOrganisatorWithRequest($member, $organisator, $request)
    {
        $member->setImagePath($request->getPost('imagePath'));
        $member->setPrename($request->getPost('prename'));
        $member->setName($request->getPost('name'));
		
		$organisator->setMember($member);
		$organisator->setCarnivalYear($this->getCurrentCarnivalYear());
		$organisator->setResponsabilities($request->getPost('responsabilities'));
    }
}
