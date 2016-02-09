<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Helper base class. All helpers should extend this class.
 *
 * @package    Kohana
 * @category   Helpers
 * @author     Dariusz Rorat
 * @copyright  (c) 2015 Dariusz Rorat
 * @license    http://kohanaframework.org/license
 */

abstract class Kohana_Helper {
	/**
	 * Create a new helper instance.
	 *
	 *     $model = Helper::factory($name);
	 *
	 * @param   string   helper name
	 * @return  Helper
	 */

	public static function factory($name)
	{
		// Add the helper prefix
		$class = 'Helper_'.$name;

		return new $class;
	}

}// End Helper
