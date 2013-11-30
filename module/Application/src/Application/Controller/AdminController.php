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

use Application\Form\LoginForm;
use Application\Form\LoginFilter;
use Application\Controller\AbstractCarnassoController;



class AdminController extends AbstractCarnassoController
{
    public function loginAction()
    {
        $form = new LoginForm();
        $messages = null;

        
        $request = $this->getRequest();
        if ($request->isPost())
        {
            $form->setInputFilter(new LoginFilter($this->entity()->getUserRepository()));
            $form->setData($request->getPost());
            
            if ($form->isValid())
            {
                $data = $form->getData();
                $authService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');                
                
                $adapter = $authService->getAdapter();
                $adapter->setIdentityValue($data['username']);
                $adapter->setCredentialValue($data['password']);
                $authResult = $authService->authenticate();
                if ($authResult->isValid()) {
                        $identity = $authResult->getIdentity();
                        $authService->getStorage()->write($identity);
                        $time = 18000; // 5 hours:  18000  / 3600 = 5h
                        return $this->redirect()->toRoute('index');
                }
                foreach ($authResult->getMessages() as $message)
                {
                        $messages .= "$message\n"; 
                }        
            }
        }
        
        return new ViewModel( array(
            'form'        => $form,
            'messages'    => $messages
        ));
    }
    
    public function logoutAction()
    {
        $auth = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
        
        if ($auth->hasIdentity()) {
            $identity = $auth->getIdentity();
        }
        $auth->clearIdentity();
        $sessionManager = new \Zend\Session\SessionManager();
        $sessionManager->forgetMe();
        
        return $this->redirect()->toRoute('index');
        
    } 
}
