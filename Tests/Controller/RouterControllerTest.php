<?php

namespace mssimi\ContentManagementBundle\Tests\Controller;

use mssimi\ContentManagementBundle\Document\Article;
use mssimi\ContentManagementBundle\Document\Blog;
use mssimi\ContentManagementBundle\Document\Page;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RouterControllerTest extends WebTestCase
{
    public static function setUpBeforeClass()
    {
        $client = static::createClient();
        $container = $client->getContainer();
        $dm = $container->get('doctrine_phpcr')->getManager();

        $parent = $dm->find(null, '/cms/page');

        $page = new Page();
        $page->setParent($parent);
        $page->setName('page');
        $page->setHeading('page');

        $dm->persist($page);

        $blog = new Blog();
        $blog->setParent($parent);
        $blog->setName('blog');
        $blog->setHeading('blog');

        $dm->persist($blog);

        $article = new Article();
        $article->setParent($blog);
        $article->setName('article');
        $article->setHeading('article');

        $dm->persist($article);

        $dm->flush();
    }

    public static function tearDownAfterClass()
    {
        $client = static::createClient();
        $container = $client->getContainer();
        $dm = $container->get('doctrine_phpcr')->getManager();

        $page = $dm->find(null, '/cms/page/page');
        $article = $dm->find(null, '/cms/page/blog/article');
        $blog = $dm->find(null, '/cms/page/blog');

        $dm->remove($page);
        $dm->remove($article);
        $dm->remove($blog);

        $dm->flush();
    }

    public function testPageAction()
    {
        $client = static::createClient();
        $client->request('GET', '/page');
        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    public function testBlogAction()
    {
        $client = static::createClient();
        $client->request('GET', '/blog');
        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    public function testArticleAction()
    {
        $client = static::createClient();
        $client->request('GET', '/blog/article');
        $this->assertTrue($client->getResponse()->isSuccessful());
    }
}