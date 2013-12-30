<?php namespace Andheiberg\Asset;

class AssetManager {

	/**
	 * Cache manifest.
	 *
	 * @var stdClass
	 */
	protected $manifest;

	/**
	 * Create a new asset instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->loadManifest();
	}

	/**
	 * Load the cache manifest.
	 *
	 * @return void
	 */
	public function loadManifest()
	{
		$manifest = file_get_contents(storage_path().'/meta/cachebusters.json');
		
		$this->manifest = json_decode($manifest);
	}

	/**
	 * Check if an asset is in the manifest.
	 *
	 * @param  string  $url
	 * @return boolean
	 */
	public function has($url)
	{
		return isset($this->manifest->$url);
	}

	/**
	 * Get an asset from the manifest.
	 *
	 * @param  string  $url
	 * @return string
	 */
	public function get($url)
	{
		if ( ! $this->has($url))
		{
			throw new NotFoundException;
		}

		return $this->manifest->$url;	
	}

}

class NotFoundException extends \Exception {}