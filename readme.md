# Rixxi/Gedmo


## Requirements

- [Kdyby/Doctrine](https://github.com/kdyby/doctrine)
- [l3pp4rd/DoctrineExtensions](https://github.com/l3pp4rd/DoctrineExtensions)


## Installation

<<<<<<< HEAD
The best way to install Rixxi/Gedmo is using  [Composer](http://getcomposer.org/):
=======
The best way to install Rixxi/Gedmo is using [Composer](http://getcomposer.org/).
Also fixes [compatibility issue](https://github.com/Kdyby/Events/pull/34) with [Kdyby\Events](https://github.com/kdyby/events).

Add to your `composer.json`:
>>>>>>> readme updated

```sh
$ composer require rixxi/gedmo:@dev
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
