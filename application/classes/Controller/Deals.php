<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Deals extends Controller_Base
{

    public function before()
    {
        parent::before();
    }

    public function action_index()
    {
        $this->template->content = View::factory('deals/index')
                ->bind('products', $products)
                ->bind('numproducts', $numproducts)
                ->bind('filter_name', $merchant);

        $merchant = '';
        $results_per_page = 0;
        // get url params
        if (($this->request->query('merchant') !== null) && ($this->request->query('results_per_page') !== null))
        {
            $merchant = $this->request->query('merchant');
            $results_per_page = $this->request->query('results_per_page');
        }

        
        $key = Kohana::$config->load('rest')->get('hotukdeals')['api_key'];
        $fmt = Kohana::$config->load('rest')->get('hotukdeals')['api_search_url_fmt'];
        $url = sprintf($fmt, $key, $merchant, $results_per_page);
        $cache_life = Kohana::$config->load('rest')->get('hotukdeals')['cache_life'];
        $cache_key = 'products:' . $url;

        // retrieve cached data from RESTful service
        try
        {
            if (($products = Kohana::cache($cache_key, NULL, $cache_life)) === NULL)
            {
                $objects = Helper::factory('REST')
                        ->url($url)
                        ->as_object()
                        ->execute();

                $products = $objects->deals->items;

                foreach ($products as $product)
                {
                    $product->display_page_url = $this->_get_product_display_page($product->deal_image);
                }

                $products = $this->_remove_expired_products($products);
                $products = $this->_order_by_temperature($products);

                // store retrieved products to cache
                Kohana::cache($cache_key, $products, $cache_life);
            }
            $numproducts = count($products);
        } catch (ErrorException $e)
        {
            //clear cache
            Kohana::cache($cache_key, NULL, 0);
            if (is_object(Kohana::$log))
            {
                Kohana_Exception::log($e);
            }
            $this->template->content = View::factory('deals/error');
        }
    }

    public function after()
    {
        $this->template->style[] = $this->__CSS__ . 'deals.css';
        parent::after();
    }

    private function _get_product_display_page($image_url)
    {
        $prefix = Kohana::$config->load('rest')->get('hotukdeals')['product_display_page_prefix'];
        $suffix = substr(basename($image_url), 0, strpos(basename($image_url), '_'));
        return $prefix . $suffix;
    }

    private function _remove_expired_products($array)
    {
        $result = array();
        foreach ($array as $value)
        {
            if ($value->expired == 'false')
            {
                $result[] = $value;
            }
        }
        return $result;
    }

    private function _order_by_temperature($array)
    {
        $data = $array;
        usort($data, function($a, $b)
        {
            return $b->temperature - $a->temperature;
        });
        return $data;
    }

    private function _get_current_gbp_exchange_rate()
    {
        $base = Kohana::$config->load('rest')->get('exchanges')['base'];
        $symbols = Kohana::$config->load('rest')->get('exchanges')['symbols'];
        $fmt = Kohana::$config->load('rest')->get('exchanges')['exchange_rate_api_url_fmt'];
        $cache_life = Kohana::$config->load('rest')->get('exchanges')['cache_life'];

        $url = sprintf($fmt, $base, $symbols);
        $objects = Helper::factory('REST')
                ->url($url)
                ->cached($cache_life)
                ->as_object()
                ->execute();

        return $objects->rates->GBP;
    }

}
