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


class IndexController extends AbstractActionController
{
    private function getMenuParameters()
    {
        $carinvalYearRepository = $this->entity()->getCarnivalYearRepository();
        $carnivalYears = $carinvalYearRepository->findBy(array(), array('year' => 'DESC'));
            
        $years = array();
        foreach($carnivalYears as $year)
        {
            array_push($years, $year->getYear());
        }
        
        $year = (int) $this->params()->fromRoute('year', 0);
        if(!$year || !in_array($year, $years))
        {
            $year = $carnivalYears[0]->getYear();
        }
        
        return array(
            'currentYear' => $year,
            'years' => $years,
            'currentController' => 'index',
            'currentAction' => $this->params('action'),
        );
    }
    
    public function indexAction()
    {           
        return new ViewModel(array(
            'menuParams' => $this->getMenuParameters(),
        ));
    }
}
