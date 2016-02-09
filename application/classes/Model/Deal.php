<?php

defined('SYSPATH') OR die('No Direct Script Access');

class Model_Deal extends Model
{
    protected $_data = array();

    public function __get($name)
    {
        return isset($this->_data[$name]) ? $this->_data[$name] : null;
    }

    public function __set($name, $value)
    {
        $this->_data[$name] = $value;
    }

    public function __isset($name)
    {
        return isset($this->_data[$name]);
    }

}
