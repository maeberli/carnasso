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
use Application\Model\Entity\CarnivalYear;


class AbstractCarnassoController extends AbstractActionController
{
    const PUBLIC_IMGPATH = "/img/carnasso/";
    const LOCAL_IMGPATH = "./public/img/carnasso/";
    
    private $basePath = null;
    private $auth = null;

    protected function getMenuParameters()
    {
        $carinvalYearRepository = $this->entity()->getCarnivalYearRepository();
        $carnivalYears = $carinvalYearRepository->findBy(array(), array('year' => 'DESC'));
            
        $years = array();
        foreach($carnivalYears as $year)
        {
            array_push($years, $year->getYear());
        }
        
        $year = $this->getCurrentCarnivalYear()->getYear();
        
        return array(
            'currentYear' => $year,
            'years' => $years,
            'currentController' => $this->getEvent()->getRouteMatch()->getMatchedRouteName(),
            'currentAction' => $this->params('action'),
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
        $styles = 'img.bg{content: url(\''.$this->getBasePath().self::PUBLIC_IMGPATH.$this->getCurrentCarnivalYear()->getBackgroundImgPath().'\');}';
        $this->getServiceLocator()->get('ViewRenderer')->headStyle()->appendStyle($styles);
    }    
}
