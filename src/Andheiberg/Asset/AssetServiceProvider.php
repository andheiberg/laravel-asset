<?php namespace Andheiberg\Asset;

use Andheiberg\Asset\Commands\WatchCommand;
use Andheiberg\Asset\Commands\BuildCommand;
use Andheiberg\Asset\Commands\SetupCommand;
use Illuminate\Support\ServiceProvider;

class AssetServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->package('andheiberg/asset', 'asset');

		// Register 'asset' instance container to our Asset object
		$this->app['asset.manager'] = $this->app->share(function($app)
		{
			return new AssetManager;
		});

		// Register 'asset' instance container to our Asset object
		$this->app['asset'] = $this->app->share(function($app)
		{
			return new Asset($app['asset.manager']);
		});

		// Shortcut so developers don't need to add an Alias in app/config/app.php
		$this->app->booting(function()
		{
			$loader = \Illuminate\Foundation\AliasLoader::getInstance();
			$loader->alias('Asset', 'Andheiberg\Asset\Facades\Asset');
		});

		$this->registerBladeExtensions();
		$this->registerConsoleCommands();
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('asset');
	}

	/**
	 * Register the Blade extensions with the compiler.
	 * 
	 * @return void
	 */
	protected function registerBladeExtensions()
	{
		$blade = $this->app['view']->getEngineResolver()->resolve('blade')->getCompiler();

		$blade->extend(function($value, $compiler)
		{
			$matcher = $compiler->createMatcher('js');
			
			return preg_replace($matcher, '$1<?php echo Asset::js$2; ?>', $value);
		});

		$blade->extend(function($value, $compiler)
		{
			$matcher = $compiler->createMatcher('css');
			
			return preg_replace($matcher, '$1<?php echo Asset::css$2; ?>', $value);
		});

		$blade->extend(function($value, $compiler)
		{
			$matcher = $compiler->createMatcher('asset');
			
			return preg_replace($matcher, '$1<?php echo Asset::url$2; ?>', $value);
		});
	}

	/**
	 * Register the console commands.
	 * 
	 * @return void
	 */
	protected function registerConsoleCommands()
	{
		$this->app['asset.watch'] = $this->app->share(function($app)
		{
			return new WatchCommand;
		});

		$this->app['asset.build'] = $this->app->share(function($app)
		{
			return new BuildCommand;
		});

		$this->app['asset.setup'] = $this->app->share(function($app)
		{
			return new SetupCommand($app['files']);
		});

		$this->commands('asset.watch', 'asset.build', 'asset.setup');
	}

}