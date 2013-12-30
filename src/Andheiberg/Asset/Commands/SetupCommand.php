<?php namespace Andheiberg\Asset\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Filesystem\Filesystem;

class SetupCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'asset:setup';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Setup asset workflow.';

	/**
	 * The filesystem instance.
	 *
	 * @var Illuminate\Filesystem\Filesystem
	 */
	protected $filesystem;

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct(Filesystem $filesystem)
	{
		parent::__construct();

		$this->filesystem = $filesystem;
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$this->createAssetFolders();
		$this->createSetupFiles();

		$this->info('Asset setup!');
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function createAssetFolders()
	{
		$appAssets = app_path().'/assets';
		$appAssetsStub = __DIR__.'/../Stubs/assets';

		if ($this->filesystem->exists($appAssets))
		{
			if ($this->confirm('"app/assets" already exists do you wish to overwrite it? [yes|no]'))
			{
				$this->filesystem->copyDirectory($appAssetsStub, $appAssets);
				$this->info('Created "app/assets"');
			}
		}
		else
		{
			$this->filesystem->copyDirectory($appAssetsStub, $appAssets);
			$this->info('Created "app/assets"');
		}

		if ($this->filesystem->exists(public_path().'/assets'))
		{
			if ($this->confirm('"public/assets" already exists do you wish to overwrite it? [yes|no]'))
			{
				$this->filesystem->makeDirectory(public_path().'/assets', 0777, false, true);
				$this->info('Created "app/assets"');
			}
		}
		else
		{
			$this->filesystem->makeDirectory(public_path().'/assets');
			$this->info('Created "public/assets"');
		}
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function createSetupFiles()
	{
		$gruntfile = base_path().'/Gruntfile.js';
		$gruntfileStub = __DIR__.'/../Stubs/Gruntfile.js';

		if ($this->filesystem->exists($gruntfile))
		{
			if ($this->confirm('"Gruntfile.js" already exists do you wish to overwrite it? [yes|no]'))
			{
				$this->filesystem->copy($gruntfileStub, $gruntfile);
				$this->info('Published "Gruntfile.js"');
			}
		}
		else
		{
			$this->filesystem->copy($gruntfileStub, $gruntfile);
			$this->info('Published "Gruntfile.js"');
		}

		$package = base_path().'/package.json';
		$packageStub = __DIR__.'/../Stubs/package.json';

		if ($this->filesystem->exists($package))
		{
			if ($this->confirm('"package.json" already exists do you wish to overwrite it? [yes|no]'))
			{
				$this->filesystem->copy($packageStub, $package);
				$this->info('Published "package.json"');
			}
		}
		else
		{
			$this->filesystem->copy($packageStub, $package);
			$this->info('Published "package.json"');
		}
	}

}
