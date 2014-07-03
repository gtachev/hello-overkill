<?php

namespace Application;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ServiceManager\ServiceManager;

return array(
    'factories' => array(
        'dbAdapter' => function(ServiceManager $sm) {
            $config = $sm->get('Config');
            $dbAdapter = new \Zend\Db\Adapter\Adapter($config['db']);
            return $dbAdapter;
        },
        'dbCache' => function(ServiceManager $sm){
            $config = $sm->get('Config');
            $cacheConfig = $config['cache_config'];
            $cache = \Zend\Cache\StorageFactory::factory($config[$cacheConfig]);
            return $cache;
        },
        'TextTable' => function(ServiceManager $sm) {
            $tableGateway = $sm->get('TextTableGateway');
            $cache = $sm->get('dbCache');
            $table = new Model\TextTable($tableGateway, $cache);
            return $table;
        },
        'TextTableGateway' => function (ServiceManager $sm) {
            $dbAdapter = $sm->get('dbAdapter');
            $resultSetPrototype = new ResultSet();
            $resultSetPrototype->setArrayObjectPrototype(new Model\Text());
            return new TableGateway('texts', $dbAdapter, null, $resultSetPrototype);
        },
    ),
);
