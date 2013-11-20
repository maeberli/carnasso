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
use Application\Controller\AbstractCarnassoController;

class ManagementController extends AbstractCarnassoController
{
    public function loginAction()
    {
        $form = new LoginForm();
        //$form->get('submit')->setValue('Login');
        
        return new ViewModel( array(
            'form'        => $form
        ));
    }
}
