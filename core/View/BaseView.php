<?php
namespace core\View;

/**
 * 视图基类
 */
class BaseView
{
    protected $variables = array();
    protected $_controller;
    protected $_action;

    function __construct($controller, $action)
    {
        $this->_controller = strtolower($controller);
        $this->_action = strtolower($action);
    }

    public function assign($name, $value)
    {
        $this->variables[$name] = $value;
    }

    public function render()
    {
        try {
            extract($this->variables);
            $file = APP_PATH . 'app/views/' . $this->_controller . '/' . $this->_action . '.php';
            if (file_exists($file)){
                require_once $file;
            }else{
                require_once APP_PATH . 'static/page/404.html';
            }
        }catch (\Exception $e){
            echo $e->getMessage();
        }

    }
}
