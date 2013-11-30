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
            'currentController' => 'index',
            'currentAction' => $this->params('action'),
        );
    }
    
    protected function getCurrentCarnivalYear()
    {
        $carinvalYearRepository = $this->entity()->getCarnivalYearRepository();
        $year = null;
        
        $yearNumber = (int) $this->params()->fromRoute('year', 0);
        
        if($yearNumber)
        {
            print($yearNumber);
            $year = $carinvalYearRepository->findOneBy(array('year' => $yearNumber));
        }
        else
        {
            $years =  $carinvalYearRepository->findBy(array(), array('year' => 'DESC'));
            $year = (count($years)>0 ? $years[0] : null);
        }
        
        return $year;
    }
}
