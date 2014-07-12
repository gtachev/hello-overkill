<?php

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\Http\AbstractMessage;

class Module implements
    AutoloaderProviderInterface, 
    ConfigProviderInterface, 
    ServiceProviderInterface
{

    public function onBootstrap(MvcEvent $e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        $eventManager->attach(MvcEvent::EVENT_FINISH, array($this, 'trimOutput'));
    }
    
    public function trimOutput(MvcEvent $e)
    {
        $response = $e->getResponse();
        if ($response instanceof AbstractMessage) {
            $body = $response->getBody();
            $trimmedBody = preg_replace('/ +/', ' ', $body);
            $response->setContent($trimmedBody);
        }
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getServiceConfig()
    {
        return require(__DIR__ . '/config/services.config.php');
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

}
