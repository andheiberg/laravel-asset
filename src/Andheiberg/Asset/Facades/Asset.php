<?php namespace Andheiberg\Asset\Facades;

use Illuminate\Support\Facades\Facade as Facade;

/**
 * @see \Andheiberg\Asset\Asset
 */
class Asset extends Facade {

	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor() { return 'asset'; }

}