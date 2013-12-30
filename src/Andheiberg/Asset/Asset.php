<?php namespace Andheiberg\Asset;

class Asset {

	/**
	 * AssetManager instance.
	 *
	 * @var Andheiberg\Asset\AssetManager
	 */
	protected $manager;

	/**
	 * Create a new asset instance.
	 *
	 * @param  Illuminate\Filesystem\Filesystem  $filesystem
	 * @return void
	 */
	public function __construct(AssetManager $manager)
	{
		$this->manager = $manager;
	}

	/**
	 * Get the cachebuster url for an asset.
	 *
	 * @param  string  $url
	 * @return string
	 */
	public function url($url)
	{
		if ($this->manager->has($url))
		{
			$url = $this->manager->get($url);
		}

		return $url;
	}

	/**
	 * Get the html embed for a css asset.
	 *
	 * @param  string  $asset
	 * @return string
	 */
	public function css($asset)
	{
		$url = $this->url("/assets/css/{$asset}.css");

		return "<link rel=\"stylesheet\" href=\"{$url}\">";
	}

	/**
	 * Get the html embed for a js asset.
	 *
	 * @param  string  $asset
	 * @return string
	 */
	public function js($asset)
	{
		$url = $this->url("/assets/js/{$asset}.js");

		return "<script src=\"{$url}\"></script>";
	}



}