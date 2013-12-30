<?php namespace Andheiberg\Asset\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class WatchCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'asset:watch';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Watch and build your assets for development.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$stream = popen("grunt", "r");

		if (ob_get_level() == 0)
		{
			ob_start();
		}

		while( ! feof($stream))
		{
			$buffer = fgets($stream);

			echo $buffer;

			ob_flush();
			flush();
		}

		pclose($stream);
		ob_end_flush();
	}

}
