<?php

namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;

class TextTable
{

    protected $tableGateway;
    protected $cache;

    public function __construct(TableGateway $tableGateway, $cache)
    {
        $this->tableGateway = $tableGateway;
        $this->cache = $cache;
    }

    public function getText($key, $langCode)
    {
        $cacheKey = $key . '_' . $langCode;
        $result = $this->cache->getItem($cacheKey, $success);

        if (!$success) {
            $select = $this->tableGateway->getSql()->select();
            $select->columns(array('text'));
            $select->join('languages', 'languages.id = texts.language_id', array('language'), 'left');
            $select->where->equalTo('key', $key);
            $select->where->equalTo('language', $langCode);

            $result = $this->tableGateway->selectWith($select)->toArray();
            $this->cache->setItem($cacheKey, $result);
        }

        $text = array_shift($result);

        return isset($text['text']) ? $text['text'] : null;
    }

}
