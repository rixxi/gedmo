Rixxi/Gedmo
===


Requirements
---

- [Kdyby/Doctrine](https://github.com/kdyby/doctrine)
- [l3pp4rd/DoctrineExtensions](https://github.com/l3pp4rd/DoctrineExtensions)


Installation
---

The best way to install Rixxi/Gedmo is using  [Composer](http://getcomposer.org/):

```sh
$ composer require rixxi/gedmo:@dev
```

Configuration
---

```yml
extensions:
	doctrine: Kdyby\Doctrine\DI\OrmExtension # don't forget dependency
	gedmo: Rixxi\Gedmo\DI\Extension

gedmo:
	extensions:
		blameable: on
		loggable: on
		sluggable: on
		timestampable: on
		translatable: on
		tree: on
```


Softdeleteable
---

```yml
doctrine:
	types:
		bit: Doctrine\DBAL\Types\BooleanType
	filters:
		soft-deleteable: Gedmo\SoftDeleteable\Filter\SoftDeleteableFilter
```
