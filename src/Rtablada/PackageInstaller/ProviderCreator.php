<?php namespace Rtablada\PackageInstaller;

use Illuminate\Filesystem\Filesystem as File;

class ProviderCreator
{
	/**
	 * Instance of the File class
	 *
	 * @var \Illuminate\Filesystem\Filesystem
	 */
	protected $file;

	/**
	 * Creates the ProviderCreator Instance
	 *
	 * @param Illuminate\Filesystem\Filesystem     $file
	 * @param Provider $provider
	 */
	function __construct(File $file, Provider $provider)
	{
		$this->file = $file;
		$this->provider = $provider;
	}

	/**
	 * Creates a Provider Instance from a file path
	 * @param  string $path
	 * @return Provider
	 */
	public function buildProviderFromJsonFile($path)
	{
		if ($this->file->exists($path)) {
			$contents = $this->file->get($path);
			return $this->provider->buildFromJson($contents);
		}

		return null;
	}
}