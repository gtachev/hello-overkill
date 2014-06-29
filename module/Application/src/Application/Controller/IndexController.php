<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        $textTable = $this->getServiceLocator()->get('TextTable');
        $text = $textTable->getText('hello','en');
        return new ViewModel(array(
            'greeting' => $text,
        ));
    }
}
