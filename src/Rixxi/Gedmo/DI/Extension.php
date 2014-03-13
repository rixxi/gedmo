<?php

namespace Rixxi\Gedmo\DI;

use Kdyby\Doctrine\DI\IEntityProvider;
use Nette\DI\CompilerExtension;


class Extension extends CompilerExtension implements IEntityProvider
{
	/** @var array */
	private $defaults = array(
		'extensions' => array(
			'blameable' => FALSE,
			'loggable' => FALSE,
			'sluggable' => FALSE,
			'timestampable' => FALSE,
			'translatable' => FALSE,
			'tree' => FALSE
		),
		'listeners' => array(
			'blameable' => 'Gedmo\Blameable\BlameableListener',
			'sluggable' => 'Gedmo\Sluggable\SluggableListener',
			'timestampable' => 'Gedmo\Timestampable\TimestampableListener',
			'translatable' => 'Gedmo\Translatable\TranslatableListener',
			'tree' => 'Gedmo\Tree\TreeListener'
		),
		'entityAnnotations' => array('loggable', 'translatable', 'tree')
	);


	public function loadConfiguration()
	{
		$config = $this->getConfig($this->defaults);
		$builder = $this->containerBuilder;

		foreach ($config['extensions'] as $name => $active) {
			if ($active && isset($config['listeners'][$name])) {
				$definition = $builder->addDefinition($this->prefix($name))
					->setClass($config['listeners'][$name])
					->addSetup('setAnnotationReader', array('@Doctrine\Common\Annotations\Reader'))
					->addTag('kdyby.subscriber')
					->setAutowired(FALSE);

				if ($name == 'translatable') {
					$definition->addSetup('$service->setTranslatableLocale($this->getService(?)->getLocale())', array('translation.default'));
				}
			}
		}
	}


	/**
	 * @return array
	 */
	public function getEntityMappings()
	{
		$config = $this->getConfig($this->defaults);
		$path = realpath(__DIR__ . '/../../../../../../gedmo/doctrine-extensions/lib/Gedmo');

		$mappings = array();
		foreach ($config['entityAnnotations'] as $annotation) {
			if ($config['extensions'][$annotation]) {
				$name = ucfirst($annotation);
				$mappings["Gedmo\\$name\\Entity"] = "$path/$name/Entity";
			}
		}

		return $mappings;
	}

}
