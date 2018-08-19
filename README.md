Template Bundle
===============
### By D'Ali Ben Macha <contact@benmacha.tn> [https://dali.benmacha.tn](https://dali.benmacha.tn) ###

Symfony bundle to generate template with a nice design in your Symfony application.

[![Latest Stable Version](https://poser.pugx.org/benmacha/templatebundle/version)](https://packagist.org/packages/benmacha/templatebundle) [![Total Downloads](https://poser.pugx.org/benmacha/templatebundle/downloads)](https://packagist.org/packages/benmacha/templatebundle) [![Latest Unstable Version](https://poser.pugx.org/benmacha/templatebundle/v/unstable)](//packagist.org/packages/benmacha/templatebundle) [![License](https://poser.pugx.org/benmacha/templatebundle/license)](https://packagist.org/packages/benmacha/templatebundle) 

## Installation

The easiest way to install and configure the TemplateBundle with Symfony is by using
[Composer](https://getcomposer.org/):
Add the `benmacha/templatebundle` package to your `require` section in the `composer.json` file.

``` bash
$ composer require benmacha/templatebundle ^1.0
```
Add the Bundle to your application's kernel:

``` php

<?php
public function registerBundles()
{
    $bundles = array(
        // ...
            new Benmacha\TemplateBundle\BenmachaTemplateBundle(),
        // ...
    );
    ...
}
```

Configure the `Bundle` in your `config.yml`:

``` yaml
benmacha_template:
    site_name: 'Ben Macha' #required
    logo_path: 'bundles/benmachatemplate/img/logo-2.png' #required
    logo_path_mobile: 'bundles/benmachatemplate/img/logo-2-mob.png' #required
    user:
        class: AppBundle\Entity\User
        picture: image

```


## Usage

To generate a CRUD, run this command 
`NB: The menu will be generated `

``` bash
$  php bin/console benmacha:generate:crud
```

Don't forget to extend the repository like this

``` php

<?php

namespace AppBundle\Repository;

use Benmacha\TemplateBundle\Repository\BaseRepository; //add this line

class UserRepository extends BaseRepository // make this extend
{
     // Your code   
}
        
```