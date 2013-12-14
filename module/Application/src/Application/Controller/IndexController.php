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
use Application\Model\Entity\CarnivalYear;
use Application\Controller\AbstractCarnassoController;
use Application\Form\CarnivalYearEditForm;
use Application\Form\CarnivalYearEditFilter;
use Application\Form\CarnivalYearNewForm;
use Application\Form\CarnivalYearNewFilter;
use Application\Form\CarnivalYearDeleteForm;

class IndexController extends AbstractCarnassoController
{
    private $extraAdminActions = array(
            'new'=>'Neues Jahr',
            'delete'=>'Aktuelles Jahr löschen',
        );
    
    public function indexAction()
    {   
        $currentYear = $this->getCurrentCarnivalYear();
        
        return new ViewModel(array(
            'menuParams' => $this->getMenuParameters($this->extraAdminActions),
            'flyerpath' => $this->getBasePath().self::PUBLIC_IMGPATH.$currentYear->getFlyerImgPath(),
        ));
    }
    
    public function manageAction()
    {
        // Authentification
        if (! $this->auth()->hasIdentity() ){
            return $this->redirect()->toRoute('admin', array('action' => 'login'));
        }
        
        
        $editForm = new CarnivalYearEditForm($this->entity()->getEntityManager());
        $currentYear = $this->getCurrentCarnivalYear();
        
        $editForm->bind($currentYear);
        
        $request = $this->getRequest();
        if ($request->isPost())
        {
            $editForm->setInputFilter(
                new CarnivalYearEditFilter($this->entity()->getCarnivalYearRepository()));
            
            $files = $request->getFiles();
            
            // Merge and post data together to pass as one unit to the edit form
            $data = array_merge_recursive(
                $request->getPost()->toArray(),           
                $request->getFiles()->toArray()
            );
            $editForm->setData($data);
            
            if ($editForm->isValid())
            {
                $currentYearChanged = false;
                
                // check if a new Flyer image was uploaded
                if($files['flyerImgPathNew']['name'] != "")
                {
                    $newImagePath = $this->uploadFile($editForm, $files, 'flyerImgPathNew');
                    if($newImagePath != null)
                    {
                        // Delete old flyer image from harddisk
                        $this->removeImage($currentYear->getFlyerImgPath());
                        
                        $currentYear->setFlyerImgPath($newImagePath);
                        $currentYearChanged = true;
                    }

                }
                
                // check if a new background image was uploaded
                if($files['backgroundImgPathNew']['name'] != "")
                {
                    $newImagePath = $this->uploadFile($editForm, $files, 'backgroundImgPathNew');
                    if($newImagePath != null)
                    {
                        // Delete old background image.
                        $this->removeImage($currentYear->getBackgroundImgPath());
                        
                        $currentYear->setBackgroundImgPath($newImagePath);
                        $currentYearChanged = true;
                    }
                }
                
                if($currentYearChanged)
                {
                    $this->entity()->getEntityManager()->persist($currentYear);
                    $this->entity()->getEntityManager()->flush();
                    
                    // Update form data
                    $editForm->bind($currentYear);
                }
            }
        }


        $currentYear = $this->getCurrentCarnivalYear();
        
        $this->setBackgroundImage();
        return new ViewModel(array(
            'menuParams' => $this->getMenuParameters($this->extraAdminActions),
            'editForm' => $editForm,
            'flyerImg' => $this->getBasePath().self::PUBLIC_IMGPATH.$currentYear->getFlyerImgPath(),
            'backgroundImg' => $this->getBasePath().self::PUBLIC_IMGPATH.$currentYear->getBackgroundImgPath(),
        ));
    }
    
    public function newAction()
    {
        // Authentification
        if (! $this->auth()->hasIdentity() ){
            return $this->redirect()->toRoute('admin', array('action' => 'login'));
        }
        
        // create form for the new carnival year.
        $newForm = new CarnivalYearNewForm(
            $this->entity()->getEntityManager(),
            $this->entity()->getCarnivalYearRepository()
        );
        
        $request = $this->getRequest();
        if ($request->isPost())
        {
            $newForm->setInputFilter(
                new CarnivalYearNewFilter($this->entity()->getCarnivalYearRepository()));
            
            $files = $request->getFiles();
            
            // Merge and post data together to pass as one unit to the edit form
            $data = array_merge_recursive(
                $request->getPost()->toArray(),           
                $request->getFiles()->toArray()
            );
            $newForm->setData($data);
            
            if ($newForm->isValid())
            {
                $newCarnivalYear = new CarnivalYear();
                
                $backgroundImgPath = $this->uploadFile($newForm, $files, 'backgroundImgPath');
                $flyerImgPath = $this->uploadFile($newForm, $files, 'flyerImgPath');
                if($backgroundImgPath != null && $flyerImgPath != null)
                {   
                    $newCarnivalYear->setYear($data['year']);
                    $newCarnivalYear->setBackgroundImgPath($backgroundImgPath);
                    $newCarnivalYear->setFlyerImgPath($flyerImgPath);
                    
                    $this->entity()->getEntityManager()->persist($newCarnivalYear);
                    $this->entity()->getEntityManager()->flush();
                }
            }
        }
        
        // return the ViewModel with the parameters for the menus
        // and the form.
        return new ViewModel(array(
            'menuParams' => $this->getMenuParameters($this->extraAdminActions),
            'newForm' => $newForm,
        ));
    }
    
    public function deleteAction()
    {
        // Authentification
        if (! $this->auth()->hasIdentity() )
        {
            return $this->redirect()->toRoute('admin', array('action' => 'login'));
        }
        
        $request = $this->getRequest();
        if ($request->isPost())
        {
            $currentYear = $this->getCurrentCarnivalYear();
            
            if($request->getPost()['cancelbutton'] != null)
            {
                // deletion aborted, redirect to manage action.
                return $this->redirect()->toRoute('index', array('action' => 'manage', 'year' => $currentYear->getYear()));
            }
            else if($request->getPost()['confirmbutton'] != null)
            {
                $flyerImgPath = $currentYear->getFlyerImgPath();
                $backgroundImgPath = $currentYear->getBackgroundImgPath();
                
                // remove current year form db
                $this->entity()->getEntityManager()->remove($currentYear);
                $this->entity()->getEntityManager()->flush();
                
                // remove images from filesystem
                $this->removeImage($flyerImgPath);
                $this->removeImage($backgroundImgPath);
                
                
                
                // Delete successfull executed, redirect to index action
                return $this->redirect()->toRoute('index', array('action' => 'index'));
            }
        }
        
        $deleteForm = new CarnivalYearDeleteForm();
        
        // return the ViewModel with the parameters for the menus
        // and the form.
        return new ViewModel(array(
            'menuParams' => $this->getMenuParameters($this->extraAdminActions),
            'deleteForm' => $deleteForm,
        ));
    }
    
    private function uploadFile($editForm, $files, $fieldname)
    {
        $fileextension = new \Zend\Validator\File\Extension(array('extension'=>array('jpg','jpeg','png')));
        
        $adapter = new \Zend\File\Transfer\Adapter\Http(); 
        $adapter->addValidator($fileextension);
        
        if (!$adapter->isValid($files[$fieldname]['name']))
        {
            $dataError = $adapter->getMessages();
            $error = array();
            foreach($dataError as $key=>$row)
            {
                $error[] = $row;
            }
            $editForm->setMessages(array($fieldname=>$error ));
            
            return null;
        }
        else
        {
            // get file extension
            $ext = pathinfo($files[$fieldname]['name'], PATHINFO_EXTENSION);
            
            // create file Rename instance to automatically move and rename the file.
            $filter = new \Zend\Filter\File\Rename(array(
                "target"    => self::LOCAL_IMGPATH."carnassoImg.".$ext,
                "randomize" => true,
            ));
            
            $filterResult = $filter->filter($files[$fieldname]);
            $newFileName = pathinfo($filterResult['tmp_name'], PATHINFO_BASENAME);
            return $newFileName;
        }
    }
    
    private function removeImage($image)
    {
        unlink(self::LOCAL_IMGPATH.$image);
    }
}
