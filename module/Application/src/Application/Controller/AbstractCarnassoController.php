<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\EventManager\EventManagerInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Model\Entity\CarnivalYear;


class AbstractCarnassoController extends AbstractActionController
{
    const PUBLIC_IMGPATH = "/img/carnasso/";
    const LOCAL_IMGPATH = "./public/img/carnasso/";
    
    private $basePath = null;
    private $auth = null;
    
    public function setEventManager(EventManagerInterface $events)
    {
        parent::setEventManager($events);

        $controller = $this;
        
        $events->attach('dispatch', function ($e) use ($controller) {

            
            if($controller->getCurrentCarnivalYear() == Null)
            {
                $routeName = $controller->getEvent()->getRouteMatch()->getMatchedRouteName();
                $action = $controller->params('action');
                $logged = $controller->auth()->hasIdentity();
                
                if($routeName != "admin" && $action != "login"
                    &&  !$logged)
                {
                    return $this->redirect()->toRoute('admin', array('action' => 'login'));
                }
                else if( !( ($routeName == "admin" && $action == "logout") || ($routeName == "index" && $action == "new")) && $logged)
                {
                    return $this->redirect()->toRoute('index', array('action' => 'new'));
                }
                    
            }
            
            if($controller->getCurrentCarnivalYear() != Null)
            {
                // set the background image for every page charged.
                $controller->setBackgroundImage();
                date_default_timezone_set('Europe/Zurich');
            }
            
            return;
        }, 100); // execute before executing action logic
    }

    protected function getMenuParameters($extraAdminActions=array())
    {
        $carinvalYearRepository = $this->entity()->getCarnivalYearRepository();
        $carnivalYears = $carinvalYearRepository->findBy(array(), array('year' => 'DESC'));
            
        $years = array();
        foreach($carnivalYears as $year)
        {
            array_push($years, $year->getYear());
        }
        
        $currentYear = $this->getCurrentCarnivalYear();
        $year = ( $currentYear != Null ? $currentYear->getYear() : "" );
        
        return array(
            'currentYear' => $year,
            'years' => $years,
            'currentController' => $this->getEvent()->getRouteMatch()->getMatchedRouteName(),
            'currentAction' => $this->params('action'),
            'extraAdminActions' => $extraAdminActions,
        );
    }
    
    protected function getCurrentCarnivalYear()
    {   
        $carinvalYearRepository = $this->entity()->getCarnivalYearRepository();
        $year = null;
        
        $yearNumber = (int) $this->params()->fromRoute('year', 0);
        
        $currentYear=null;
        if($yearNumber)
        {
            $currentYear = $carinvalYearRepository->findOneBy(array('year' => $yearNumber));
        }
        else
        {
            $years =  $carinvalYearRepository->findBy(array(), array('year' => 'DESC'));
            $currentYear = (count($years)>0 ? $years[0] : null);
        }
        return $currentYear;
    }
    
    protected function getBasePath()
    {
        if($this->basePath == null)
        {
            $basePath = $this->getServiceLocator()->get('viewhelpermanager')->get('basePath');
            $this->basePath = $basePath();
        }
        return $this->basePath;
    }
    
    protected function auth()
    {
        if($this->auth == null)
        {
            $this->auth = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
        }
        return $this->auth;
    }

    
    protected function setBackgroundImage()
    {
        // get pathes of the current background image
        $currentYear = $this->getCurrentCarnivalYear();
        $localImgPath = self::LOCAL_IMGPATH.$currentYear->getBackgroundImgPath();
        $publicImgPath = $this->getBasePath().self::PUBLIC_IMGPATH.$currentYear->getBackgroundImgPath();
        
        // Calculate the width of the background image
        $imgWidth = getimagesize($localImgPath)[0];
        $halfImgWidth = $imgWidth / 2;
        
        // Create the css appropriate to the background image
        $styles = 'div.bg{background: url(\''.$publicImgPath.'\');}';
        $styles .= '@media screen and (max-width: '.$imgWidth.'px) { div.bg { left: 50%; margin-left: -'.$halfImgWidth.'px; }}';
        $styles .= '.bg { min-width: '.$imgWidth.'px; }';
        
        // Pass the style sheeto the view renderer.
        $this->getServiceLocator()->get('ViewRenderer')->headStyle()->appendStyle($styles);
    }    
}
