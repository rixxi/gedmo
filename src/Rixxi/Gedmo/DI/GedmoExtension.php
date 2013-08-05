<?php

namespace Rixxi\Gedmo\DI;

use Kdyby;
use Nette\DI\CompilerExtension;
use Nette\Utils\Validators;
use Nette;


class GedmoExtension extends CompilerExtension
{

	private $defaults = array(
		'translatableLocale' => 'cs_CZ',
		'defaultLocale'	=> 'cs_CZ'
	);


	public function loadConfiguration()
	{
		$config = $this->getConfig($this->defaults);

		Validators::assertField($config, 'translatableLocale', 'string');
		Validators::assertField($config, 'defaultLocale', 'string');

		$this->loadConfig('annotation');


		$builder = $this->getContainerBuilder();
		$translatable = $builder->getDefinition($this->prefix('annotation.translatable'));
		$translatable->addSetup('setTranslatableLocale', array($config['translatableLocale']));
		$translatable->addSetup('setDefaultLocale', array($config['defaultLocale']));
	}


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
