<?php

defined('SYSPATH') OR die('No Direct Script Access');

class Helper_REST extends Helper
{

    private $_url = null;
    private $_is_cached = false;
    private $_as_object = false;
    private $_cache_life;

    public function __construct() {}

    public function url($url)
    {
        $this->_url = $url;
        return $this;
    }

    public function cached($lifetime = NULL)
    {
        if ($lifetime === NULL)
        {
            $lifetime = Kohana::$cache_life;
        }

        $this->_is_cached = true;
        $this->_cache_life = $lifetime;
        return $this;
    }

    public function as_object()
    {
        $this->_as_object = true;
        return $this;
    }

    public function execute()
    {
        if ($this->_is_cached === true)
        {
            $cache_key = 'REST-api-result' . $this->_url;
            if (($result = Kohana::cache($cache_key, NULL, $this->_cache_life)) !== NULL)
            {
                return $this->_as_object ? json_decode($result) : $result;
            } else
            {
                $result = $this->_execute_request($this->_url);
                Kohana::cache($cache_key, $result, $this->_cache_life);
                return $this->_as_object ? json_decode($result) : $result;
            }
        }

        // get data if caching is disabled
        $result = $this->_execute_request($this->_url);
        return $this->_as_object ? json_decode($result) : $result;
    }

    public function __toString()
    {
        return 'REST api Helper';
    }

    private function _execute_request($url)
    {
        if (Kohana::$profiling)
        {
            $benchmark = Profiler::start("Helper ({$this})", $this->_url);
        }

        $request = Request::factory($url);
        $response = $request->execute();


        if (isset($benchmark))
        {
            Profiler::stop($benchmark);
        }
        return $response->body();
    }

}
