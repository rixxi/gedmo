<?php

namespace Rixxi\Gedmo\DI;

use Gedmo\DoctrineExtensions;
use Kdyby;
use Nette\DI\CompilerExtension;
use Nette\Utils\Validators;
use Nette;


class OrmExtension extends CompilerExtension implements Kdyby\Doctrine\DI\IEntityProvider
{

	/**
	 * @var array
	 */
	private $defaults = [
		'translatableLocale' => 'cs_CZ',
		'defaultLocale'	=> 'cs_CZ',
		// enable all
		'all' => FALSE,
		// enable per annotation
		'loggable' => FALSE,
		'sluggable' => FALSE,
		'softDeleteable' => FALSE,
		'sortable' => FALSE,
		'timestampable' => FALSE,
		'translatable' => FALSE,
		'treeable' => FALSE,
		'uploadable' => FALSE,
	];

	/**
	 * @var array
	 */
	private $annotations = [
		'loggable',
		'sluggable',
		'softDeleteable',
		'sortable',
		'timestampable',
		'translatable',
		'treeable',
		'uploadable',
	];

	/**
	 * @return array
	 * @throws Nette\Utils\AssertionException
	 * @throws \ReflectionException
	 */
	public function getEntityMappings(): array
	{
		$config = $this->getValidatedConfig();

		$annotations = [
			'loggable' => 'Loggable',
			'translatable' => 'Translatable',
			'treeable' => 'Tree',
		];

		$reflection = new \ReflectionClass(DoctrineExtensions::class);
		$path = dirname($reflection->getFileName());

		$mappings = [];
		foreach ($annotations as $annotation => $namespace) {
			if ($config['all'] || $config[$annotation]) {
				$mappings["Gedmo\\$namespace\\Entity"] = "$path/$namespace/Entity";
			}
		}

		return $mappings;
	}

	/**
	 * @throws Nette\Utils\AssertionException
	 */
	public function loadConfiguration(): void
	{
		$config = $this->getValidatedConfig();

		$this->loadConfig('gedmo');

		$builder = $this->getContainerBuilder();
		$translatable = $builder->getDefinition($this->prefix('gedmo.translatable'));
		$translatable->addSetup('setTranslatableLocale', [$config['translatableLocale']]);
		$translatable->addSetup('setDefaultLocale', [$config['defaultLocale']]);

		foreach ($this->annotations as $annotation) {
			if ($config['all'] || $config[$annotation]) {
				continue;
			}

			$builder->removeDefinition($this->prefix("gedmo.$annotation"));
		}
	}

	/**
	 * @throws Nette\Utils\AssertionException
	 */
	public function beforeCompile()
	{
		$eventsExt = NULL;
		foreach ($this->compiler->getExtensions() as $extension) {
			if ($extension instanceof Kdyby\Doctrine\DI\OrmExtension) {
				$eventsExt = $extension;
				break;
			}
		}

		if ($eventsExt === NULL) {
			throw new Nette\Utils\AssertionException('Please register the required Kdyby\Doctrine\DI\OrmExtension to Compiler.');
		}
	}

	/**
	 * @return array
	 * @throws Nette\Utils\AssertionException
	 */
	private function getValidatedConfig(): array
	{
		$config = $this->getConfig($this->defaults);

		Validators::assertField($config, 'translatableLocale', 'string');
		Validators::assertField($config, 'defaultLocale', 'string');
		Validators::assertField($config, 'all', 'bool');

		$atLeastOneEnabled = $config['all'];
		foreach ($this->annotations as $annotation) {
			Validators::assertField($config, $annotation, 'bool');
			$atLeastOneEnabled |= $config[$annotation];
		}

		if (!$atLeastOneEnabled) {
			throw new Nette\Utils\AssertionException('Please enable one or more annotations in configuration.');
		}

		return $config;
	}

	/**
	 * @param string $name
	 */
	private function loadConfig($name)
	{
		$this->compiler->parseServices(
			$this->getContainerBuilder(),
			$this->loadFromFile(__DIR__ . '/config/' . $name . '.neon'),
			$this->prefix($name)
		);
	}

}
