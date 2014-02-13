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
		$base = '/assets/css';
		$path = $base.'/'.str_replace('.', '/', $asset).'.css';
		
		if ($this->manager->has($path))
		{
			$url = $this->url($path);
		}
		else
		{
			$url = $this->url("{$base}/{$asset}.css");
		}

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
		$base = '/assets/js';
		$path = $base.'/'.str_replace('.', '/', $asset).'.js';

		if ($this->manager->has($path))
		{
			$url = $this->url($path);
		}
		else
		{
			$url = $this->url("{$base}/{$asset}.js");
		}

		return "<script src=\"{$url}\"></script>";
	}



}