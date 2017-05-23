# Content management mimi framework

[![Build Status](https://travis-ci.org/mssimi/ContentManagementBundle.svg?branch=master)](https://travis-ci.org/mssimi/ContentManagementBundle)
[![PHPStan](https://img.shields.io/badge/PHPStan-enabled-brightgreen.svg?style=flat)](https://github.com/phpstan/phpstan)

This bundle provides basic content management tools for your symfony project. You can integrate this bundle into your existing system to add CMS functionality or use it for simple websites.

###  Bundle implements following features:

* Blocks
* Menus
* Pages
* Blogs/Articles
* Slider(Slideshow)

Bundle contains CRUD actions as well as basic administration templates, which you can override (http://symfony.com/doc/current/templating/overriding.html). Bundle also provides simple "RouterController" for your pages.

### Installation

Open a command console, enter your project directory and execute the following command to download the latest stable version of this bundle:

``` bash
$ composer require mssimi/content-management-bundle
```

Bundle uses several other bundles you have to enable them in AppKernel.php

``` php

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
            new Vich\UploaderBundle\VichUploaderBundle(),
            new Liip\ImagineBundle\LiipImagineBundle(),
        );
    }
}
```

Routing - add this lines to your app/config/routing.yml. Warning!!! routing_page.yml must be very last!!!

``` yml

content_management_admin:
    resource: "@ContentManagementBundle/Resources/config/routing_admin.yml"
    prefix:   /admin/
_liip_imagine:
    resource: "@LiipImagineBundle/Resources/config/routing.xml"
fos_js_routing:
    resource: "@FOSJsRoutingBundle/Resources/config/routing/routing.xml"
content_management_page:
    resource: "@ContentManagementBundle/Resources/config/routing_page.yml"
    prefix:   /
```

Configuration

``` yml

content_management:
    locales: ['en','de','fr']
    items_per_page: 10 # item per page for pagination in admin
    articles_per_page: 20 # articles per page in blog pagination
    page_template: 'cms/page.html.twig'
    blog_template: 'cms/blog.html.twig'
    article_template: 'cms/article.html.twig'
    
doctrine_phpcr:
    session:
        backend:
            type: doctrinedbal
            logging: true
            profiling: true
        workspace: default
    odm:
        auto_mapping: true
        auto_generate_proxy_classes: "%kernel.debug%"
        locales:
            en: []
            de: []
            fr: []
        locale_fallback: hardcoded
        default_locale: en

ivory_ck_editor:
    default_config: default
    configs:
        default:
            contentsCss: ['//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css']
            allowedContent: true
            autoParagraph: false
            entities: false

vich_uploader:
    db_driver: orm
    mappings:
        content_management:
            uri_prefix:         /images/cms
            upload_destination: '%kernel.root_dir%/../web/images/cms'
            db_driver: phpcr

# filters used in admin, feel free to change config to fit your needs
liip_imagine:
    resolvers:
       default:
          web_path: ~
    filter_sets:
        cache: ~
        thumbnail: 
            quality: 75
            filters:
                strip: ~
                thumbnail: { size: [50, 50], mode: inset }
        slider:
            quality: 75
            filters:
                strip: ~
                thumbnail: { size: [1140, 560], mode: outbound }
```

For more info check these links
 
 * http://symfony.com/doc/master/cmf/bundles/phpcr_odm/introduction.html
 * https://github.com/egeloen/IvoryCKEditorBundle
 * https://github.com/dustin10/VichUploaderBundle
 * https://github.com/liip/LiipImagineBundle
 
Highly recommend bundle, if you want support for uploading images to your ckeditor
 * https://github.com/helios-ag/FMElfinderBundle
 
Enable caching is also higly recommended

 * http://symfony.com/doc/current/cmf/cookbook/database/doctrine_cache.html
 
Install assets
 
``` bash
$ php bin/console asset:install 
```
 
Init DB
 
``` bash
$ php bin/console doctrine:phpcr:init:dbal 
$ php bin/console doctrine:phpcr:repository:init
```

If logged as user with ROLE_CMS, all blocks, menus, sliders will show quick edit button. Add this css file to your front base.html.twig or provide your own css for edit box.

``` twig
<link rel="stylesheet" href="{{ asset('bundles/contentmanagement/css/edit.css') }}">
```

Demo here
https://github.com/mssimi/ContentManagementDemo