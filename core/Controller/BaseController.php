<?php
namespace core\Controller;

use core\Http\Request;
use core\View\BaseView;

class BaseController
{
    protected $view;

    protected $request;

    public function __construct($controller='', $action='')
    {
        $this->view = new BaseView($controller, $action);
        $this->request = new Request();
    }

    public function assign($name, $value)
    {
        $this->view->assign($name, $value);
    }

    public function render()
    {
        $this->view->render();
    }
}