# Rixxi/Gedmo


## Requirements

- [Kdyby/Doctrine](https://github.com/kdyby/doctrine)
- [l3pp4rd/DoctrineExtensions](https://github.com/l3pp4rd/DoctrineExtensions)


## Installation

The best way to install Rixxi/Gedmo is using [Composer](http://getcomposer.org/).
Also fixes [compatibility issue](https://github.com/Kdyby/Events/pull/34) with [Kdyby\Events](https://github.com/kdyby/events).

Add to your `composer.json`:

```sh
"repositories": [
	{
		"type": "vcs",
		"url": "git@github.com:mishak87/DoctrineExtensions.git"
	}
],
"require": {
	"rixxi/gedmo": "@dev",
	"gedmo/doctrine-extensions": "dev-kdyby_doctrine_compat as @dev"
}
```


## Configuration

```yml
extensions:
	doctrine: Kdyby\Doctrine\DI\OrmExtension # don't forget dependency
	gedmo: Rixxi\Gedmo\DI\Extension

gedmo:
	extensions:
		# those are off by default
		blameable: on
		loggable: on
		sluggable: on
		timestampable: on
		translatable: on
		tree: on
```

### Softdeleteable

```yml
doctrine:
	types:
		bit: Doctrine\DBAL\Types\BooleanType
	filters:
		soft-deleteable: Gedmo\SoftDeleteable\Filter\SoftDeleteableFilter
```

### Translatable

Translatable uses [Kdyby/Translation](https://github.com/kdyby/translation) translator's locale to set its own locale:

```php
$definition->addSetup('$service->setTranslatableLocale($this->getService(?)->getLocale())', array('translation.default'));
```

If you use different translator, pls make some switcher and send pull-request. Thank you.
