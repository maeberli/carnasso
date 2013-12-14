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
        $this->setBackgroundImage();
        
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
        $this->setBackgroundImage();
        
        // Getting last year
        $carinvalYearRepository = $this->entity()->getCarnivalYearRepository();
        $currentCarnivalYear = $carinvalYearRepository->findOneBy(array('year' => $this->getCurrentCarnivalYear()->getYear()), array('year' => 'DESC'));
        
        // Management buttons
        $editForm = new EditEventButton();
        $deleteForm = new DeleteEventButton();
        $addForm = new AddMemberForm();

        // Setting view
        return new ViewModel(array(
            'menuParams' => $this->getMenuParameters(),
            'organisatorList' => $currentCarnivalYear->getOrganisators(),
			'imagePath' => $this->getBasePath().self::MEMBERIMGPATH,
            'addForm' => $addForm,
            'editForm' => $editForm,
            'deleteForm' => $deleteForm,
        ));
    }

    public function addAction() {
        
        $request = $this->getRequest();
        // Creating new Member entity
        $member = new Member;
        
        $member->setImagePath($request->getPost('imagePath'));
        $member->setPrename($request->getPost('prename'));
        $member->setName($request->getPost('name'));
        $member->setCarnivalYear($this->getCurrentCarnivalYear());
		
		$organisator = new Organisator;
		$organisator->setMember($member);
		$organisator->setCarnivalYear($this->getCurrentCarnivalYear());
		$organisator->setResponsabilities($request->getPost('responsabilities'));
        
        // Inserting event to database
        $this->entity()->getEntityManager()->persist($organisator);
        $this->entity()->getEntityManager()->flush();
    }

    public function editAction() {
        // Getting event
        $memberRepository = $this->entity()->getMemberRepository();
        $member = $memberRepository->findOneBy(array('id' => $this->params()->fromRoute('id', 0)));
        
        $member->setImagePath($request->getPost('imagePath'));
        $member->setPrename($request->getPost('prename'));
        $member->setName($request->getPost('name'));
        $member->setCarnivalYear($this->getCurrentCarnivalYear());
        
        
        // Updating event to database
        $this->entity()->getEntityManager()->persist($member);
        $this->entity()->getEntityManager()->flush();
    }

    public function deleteAction() {
        // Getting event
        $memberRepository = $this->entity()->getMemberRepository();
        $member = $memberRepository->findOneBy(array('id' => $this->params()->fromRoute('id', 0)));
        // Delete event from database
        $this->entity()->getEntityManager()->remove($member);
        $this->entity()->getEntityManager()->flush();
    }
}
