<?php

namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;

class TextTable
{

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function getText($key, $langCode)
    {
        $select = $this->tableGateway->getSql()->select();
        $select->columns(array('text'));
        $select->join('languages', 'languages.id = texts.language_id', array('language'), 'left');
        $select->where->equalTo('key', $key);
        $select->where->equalTo('language', $langCode);

        $result = $this->tableGateway->selectWith($select)->toArray();
        $text = array_shift($result);

        return isset($text['text']) ? $text['text'] : null;
    }

}
