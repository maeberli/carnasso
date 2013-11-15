<?php

namespace Application\Controller\Plugin;

use \Zend\Mvc\Controller\Plugin\AbstractPlugin;

class Entity extends AbstractPlugin {
    
    protected $em;
    
    public function getEntityManager() {
        if(!$this->em) {
            $this->em = $this->getController()->getServiceLocator()->get('entityManager');
        }
        
        return $this->em;
    }
    
    public function getCarnivalYearRepository()
    {
        $em = $this->getEntityManager();
        return $em->getRepository('Application\Model\Entity\CarnivalYear');
    }
}

?>
