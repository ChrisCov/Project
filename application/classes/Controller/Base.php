<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Base extends Controller_Template
{

    public $template = 'template/base';
    protected $_title;
    protected $__JS__;
    protected $__CSS__;

    public function before()
    {
        parent::before();
        $this->__JS__ = 'assets/js/';
        $this->__CSS__ = 'assets/css/';

        $this->template->style = array(
                      
                                       );
        $this->template->script = array(
                                       );
    }

    public function after()
    {
        $this->_set_profiler_view();
        parent::after();
    }

    protected function _set_profiler_view()
    {
        if ($this->request->query('profiler') == 'on')
        {
            setcookie('profiler', 'true', time() + 3600, "/");

            $this->template->stats = View::factory('profiler/stats');
        } else if ($this->request->query('profiler') == 'off')
        {
                setcookie('profiler', '', time() - 3600, "/");
        } else
        {
            $stats = isset($_COOKIE['profiler']);
            if ($stats)
            {
                $this->template->stats = View::factory('profiler/stats');
            }
        }
    }

}
