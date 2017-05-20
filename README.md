# Content management mimi framework

[![Build Status](https://travis-ci.org/mssimi/ContentManagementBundle.svg?branch=master)](https://travis-ci.org/mssimi/ContentManagementBundle)

This bundle provides basic content management tools for your symfony project. You can integrate this bundle into your existing system to add CMS functionality or use it for simple websites.

###  Bundle implements following features:

* Blocks
* Menus
* Pages
* Blogs/Articles
* Slider(Slideshow)

Bundle contains CRUD actions as well as basic administration templates, which you can override. Bundle also provides simple "RouterController" for your pages.

### Installation

Open a command console, enter your project directory and execute the following command to download the latest stable version of this bundle:

``` bash
$ composer require mssimi/content-management-bundle
```

Bundle uses several other bundles you have to enable them in AppKernel.php

``` php
<?php
// app/AppKernel.php

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...
            new mssimi\ContentManagementBundle\ContentManagementBundle(),
            new Doctrine\Bundle\PHPCRBundle\DoctrinePHPCRBundle(),
            new Knp\Bundle\PaginatorBundle\KnpPaginatorBundle(),
            new Knp\Bundle\MenuBundle\KnpMenuBundle(),
            new FOS\JsRoutingBundle\FOSJsRoutingBundle(),
            new Ivory\CKEditorBundle\IvoryCKEditorBundle(),
            new FM\ElfinderBundle\FMElfinderBundle(),
            new Vich\UploaderBundle\VichUploaderBundle(),
            new Liip\ImagineBundle\LiipImagineBundle(),
        );
    }
}
```

TODO configuration, routing

