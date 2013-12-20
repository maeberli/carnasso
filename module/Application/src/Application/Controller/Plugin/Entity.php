<?php

namespace Application\Controller\Plugin;

use \Zend\Mvc\Controller\Plugin\AbstractPlugin;

class Entity extends AbstractPlugin {
    
    protected $em;
    
    public function getEntityManager() {
        if(!$this->em)
        {
            $this->em = $this->getController()->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        }
        
        return $this->em;
    }
    
    public function getCarnivalYearRepository()
    {
        $em = $this->getEntityManager();
        return $em->getRepository('Application\Model\Entity\CarnivalYear');
    }
    
    public function getEventRepository()
    {
        $em = $this->getEntityManager();
        return $em->getRepository('Application\Model\Entity\Event');
    }

    public function getMemberRepository()
    {
        $em = $this->getEntityManager();
        return $em->getRepository('Application\Model\Entity\Member');
    }
	
    public function getOrganisatorRepository()
    {
        $em = $this->getEntityManager();
        return $em->getRepository('Application\Model\Entity\Organisator');
    }

    public function getUserRepository()
    {
        $em = $this->getEntityManager();
        return $em->getRepository('Application\Model\Entity\User');
    }

    public function getStaticPageInfoRepository()
    {
        $em = $this->getEntityManager();
        return $em->getRepository('Application\Model\Entity\StaticPageInfo');
    }
}

?>
