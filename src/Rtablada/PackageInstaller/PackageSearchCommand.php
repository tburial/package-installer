<?php namespace Rtablada\PackageInstaller;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use Packagist\Api\Client as Packagist;

class PackageSearchCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'package:search';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Searches for LPM Packages.';

	/**
	 * Instance of the Packagist API
	 * @var Packagist\Api\Client
	 */
	protected $packagist;

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct(Packagist $packagist)
	{
		parent::__construct();
		$this->packagist = $packagist;
	}

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function fire()
	{
		$query = $this->argument('query');

		$this->searchForPackages($query);
	}

	/**
	 * Searches Packagist API for LPM Packages
	 * @param  string $query
	 * @return
	 */
	protected function searchForPackages($query)
	{
		$filters = array(
			'tags' => 'lpm'
		);
		$results = $this->packagist->search($query, $filters);

		$table = $this->getHelperSet()->get('table');
		$table->setHeaders(array('Package Name', 'Package Description'));
		$rows = array();

		foreach ($results as $result) {
			$rows[] = array($result->getName(), $result->getDescription());
		}
		$table->setRows($rows)->render($this->getOutput());
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			array('query', InputArgument::REQUIRED, 'String to search for.'),
		);
	}

}
