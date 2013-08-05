Rixxi/Gedmo
===========================


Requirements
------------

Rixxi/Gedmo requires [Kdyby/Doctrine](https://github.com/kdyby/doctrine)


Installation
------------

The best way to install Rixxi/Gedmo is using  [Composer](http://getcomposer.org/):

```sh
$ composer require rixxi/gedmo:@dev
```


Configuration
------------

The best way to install Rixxi/Gedmo is using  [Composer](http://getcomposer.org/):

```yml
extensions:
	gedmo: Rixxi\Gedmo\DI\GedmoExtension
	# you should probably register Kdyby/Doctrine too
	doctrine: Kdyby\Doctrine\DI\OrmExtension

gedmo:
	translatableLocale: cs_CZ
	defaultLocale: cs_CZ

# you must add bit type to your doctrine connection
doctrine:
	types:
		bit: Doctrine\DBAL\Types\BooleanType
```


-----

Repository [http://github.com/rixxi/gedmo](http://github.com/rixxi/gedmo).
