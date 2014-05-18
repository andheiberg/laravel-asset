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

		$hash = $this->manifest->$url;

		$url = $this->addHashToUrl($url, $hash);

		return $url;
	}

	/**
	 * Add a hash to an url.
	 *
	 * @param  string  $url
	 * @param  string  $hash
	 * @return string
	 */
	public function addHashToUrl($url, $hash)
	{	
		// find position of the last dot -- where the extension starts
		$extensionPosition = strrpos($url, '.');

		return substr($url, 0, $extensionPosition) . $hash . substr($filename, $extensionPosition);
	}

}

class NotFoundException extends \Exception {}