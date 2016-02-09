<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Welcome extends Controller_Base
{

    public function before()
    {
        parent::before();
    }
    
    public function action_index()
    {
        $numbers = array(10, 20, 30, 50);
                
        $this->template->content = View::factory('welcome/index');
        
        if ($this->request->method() == HTTP_Request::POST)
        {
            $merchant = $this->request->post('merchant');
            $results_per_page = $numbers[$this->request->post('results_per_page')];
            HTTP::redirect('deals?merchant=' . $merchant . '&results_per_page=' . $results_per_page);
        }
    }

    public function after()
    {
        $this->template->style[] = $this->__CSS__ . 'welcome.css';
        parent::after();
    }
    
}
