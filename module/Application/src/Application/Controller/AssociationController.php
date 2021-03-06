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
use Zend\View\Model\JsonModel;
use Application\Model\Entity\Organisator;
use Application\Model\Entity\Member;
use Application\Model\Entity\StaticPageInfo;
use Application\Form\EditEventButton;
use Application\Form\DeleteEventButton;
use Application\Form\AddMemberForm;

class AssociationController extends AbstractCarnassoController
{
    const MEMBERIMGPATH = "/img/carnasso/";
    
    public function indexAction()
    {   
        // Getting last year
        $currentCarnivalYear = $this->getCurrentCarnivalYear();
        
        $staticContent = $this->getStaticContent();
        
        // Setting view
        return new ViewModel(array(
            'menuParams' => $this->getMenuParameters(),
            'carnivalYear' => $currentCarnivalYear,
            'association' => $staticContent[0]->getStaticText(),
            'joinus' => $staticContent[1]->getStaticText(),
            'imagePath' => $this->getBasePath().self::MEMBERIMGPATH,
        ));
    }
    
    
    public function manageAction() {
        // Authentification
        if (! $this->auth()->hasIdentity() ){
            return $this->redirect()->toRoute('admin', array('action' => 'login'));
        }
        
        // Getting last year
        $currentCarnivalYear = $this->getCurrentCarnivalYear();
        
        $staticContent = $this->getStaticContent();
        
        // Management buttons
        $addForm = new AddMemberForm();

        // Setting view
        return new ViewModel(array(
            'menuParams' => $this->getMenuParameters(),
            'carnivalYear' => $currentCarnivalYear,
            'imagePath' => $this->getBasePath().self::MEMBERIMGPATH,
            'addForm' => $addForm,
            'association' => $staticContent[0],
            'joinus' => $staticContent[1],
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
        $member = new Member();
        $this->setMemberWithRequest($member, $request);
        $member->setCarnivalYear($this->getCurrentCarnivalYear());
   
        
        // Inserting member to database
        $this->entity()->getEntityManager()->persist($member);
        $this->entity()->getEntityManager()->flush();
        
        // Setting view and return partial view to be added in manage
        $this->layout('layout/empty');
        return new ViewModel(array(
            'member' => $member,
            'imagePath' => $this->getBasePath().self::MEMBERIMGPATH,
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
        
        $addForm = new AddMemberForm();

        $addForm->get('memberPhoto')->setValue($this->getBasePath().self::PUBLIC_IMGPATH.$member->getImagePath());   
        $addForm->get('prename')->setValue($member->getPrename());
        $addForm->get('name')->setValue($member->getName());
        $addForm->get('responsabilities')->setValue($member->getResponsabilites());
                
        // Setting view and return partial view to be added in manage
        $this->layout('layout/empty');
        return new ViewModel(array(
            'id' => $member->getId(),
            'addForm' => $addForm
        ));
    }

    public function editAction() {
        // Authentification
        if (! $this->auth()->hasIdentity() ){
            return $this->redirect()->toRoute('admin', array('action' => 'login'));
        }
        
        // Getting member
        $memberRepository = $this->entity()->getMemberRepository();
        $member = $memberRepository->findOneBy(array('id' => $this->params()->fromRoute('id', 0)));
        
        $request = $this->getRequest();        
        $this->setMemberWithRequest($member, $request);     
        
        // Updating member to database
        $this->entity()->getEntityManager()->persist($member);
        $this->entity()->getEntityManager()->flush();
        
        // Setting view and return partial view to be added in manage
        $this->layout('layout/empty');
        return new ViewModel(array(
            'member' => $member,
            'imagePath' => $this->getBasePath().self::MEMBERIMGPATH,
        ));
    }

    public function deleteAction() {
        // Authentification
        if (! $this->auth()->hasIdentity() ){
            return $this->redirect()->toRoute('admin', array('action' => 'login'));
        }
        
        // Getting member
        $memberRepository = $this->entity()->getMemberRepository();
        $member = $memberRepository->findOneBy(array('id' => $this->params()->fromRoute('id', 0)));
        
        // Delete member from database
        if($member != null)
        {
            $this->entity()->getEntityManager()->remove($member);
            $this->entity()->getEntityManager()->flush();
        }
    }
    
    public function updateStaticPageInfoAction()
    {
        $request = $this->getRequest();
        $data = $request->getPost();
        
        $message = "";
        if($data['staticPageInfo'] != null && $data['id'] != null)
        {
            $text = $data['staticPageInfo'];
            $id = $data['id'];
            
            $staticPageInfoRepository = $this->entity()->getStaticPageInfoRepository();
            $info = $staticPageInfoRepository->findOneBy(array('id' => $id));
            
            if($info != null)
            {
                $info->setStaticText($text);
                
                
                $this->entity()->getEntityManager()->persist($info);
                $this->entity()->getEntityManager()->flush();
                
                return new JsonModel(array(
                    'success' => true,
                    'message' => '',
                ));
            }
            else
                $message = "no corresponding element found:";
        }
        else
            $message = "not enough parameters";
            
        return new JsonModel(array(
            'success' => false,
            'message' => $message,
        ));
    }
    
    public function setMemberWithRequest($member, $request)
    {
        if($request->getFiles()['memberPhoto']['name'] != "")
        {
            $imagePath = $this->uploadFile(new AddMemberForm(), $request->getFiles(), 'memberPhoto');
            $member->setImagePath($imagePath);
        }
        $member->setPrename($request->getPost('prename'));
        $member->setName($request->getPost('name'));
        $member->setResponsabilities($request->getPost('responsabilities'));
    }
    
    
    private function getStaticContent(){
        $staticPageInfoRepository = $this->entity()->getStaticPageInfoRepository();
        $joinus = $staticPageInfoRepository->findOneBy(array('pagename' => StaticPageInfo::JOINUS_ID));
        $aboutus = $staticPageInfoRepository->findOneBy(array('pagename' => StaticPageInfo::ABOUTUS_ID));
        
        if($joinus == null)
        {
            $joinus = new StaticPageInfo();
            $joinus->setStaticText("");
            $joinus->setPagename(StaticPageInfo::JOINUS_ID);
            
            $this->entity()->getEntityManager()->persist($joinus);
            $this->entity()->getEntityManager()->flush();
        }
        
        if($aboutus == null)
        {
            $aboutus = new StaticPageInfo();
            $aboutus->setStaticText("");
            $aboutus->setPagename(StaticPageInfo::ABOUTUS_ID);
            
            $this->entity()->getEntityManager()->persist($aboutus);
            $this->entity()->getEntityManager()->flush();
        }
        
        return [$aboutus, $joinus];
    }
}
