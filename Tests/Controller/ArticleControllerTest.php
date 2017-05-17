<?php

namespace mssimi\ContentManagementBundle\Tests\Controller;

use mssimi\ContentManagementBundle\Document\Blog;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ArticleControllerTest extends WebTestCase
{
    public static function setUpBeforeClass()
    {
        $client = static::createClient();
        $container = $client->getContainer();
        $dm = $container->get('doctrine_phpcr')->getManager();

        $parent = $dm->find(null, '/cms/page');

        $blog = new Blog();
        $blog->setParent($parent);
        $blog->setName('blog');
        $blog->setHeading('blog');

        $dm->persist($blog);
        $dm->flush();
    }

    public static function tearDownAfterClass()
    {
        $client = static::createClient();
        $container = $client->getContainer();
        $dm = $container->get('doctrine_phpcr')->getManager();

        $blog = $dm->find(null, '/cms/page/blog');

        $dm->remove($blog);
        $dm->flush();
    }

    public function testIndexAction()
    {
        $client = static::createClient();
        $client->request('GET', '/article/index//cms/page/blog');
        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    /**
     * Test new article
     */
    public function testNewSave()
    {
        $client = static::createClient();
        $client->followRedirects(true);
        $crawler = $client->request('GET', '/article/new//cms/page/blog');
        $buttonCrawlerNode = $crawler->selectButton('Submit');
        $form = $buttonCrawlerNode->form();
        $form->setValues(array(
            'article[name]' => "articleCreate",
            'article[heading]' => "articleCreate heading",
            'article[content]' => "articleCreate content",
        ));
        $crawler = $client->submit($form);
        $this->assertEquals(1, $crawler->filter('.panel tbody tr')->count());
        $this->assertEquals("articleCreate", trim($crawler->filter('.panel td')->eq(1)->text()));
    }

    /**
     * Test edit article
     */
    public function testEditSave()
    {
        $client = static::createClient();
        $client->followRedirects(true);
        $crawler = $client->request('GET', '/article/edit//cms/page/blog/articleCreate');
        $buttonCrawlerNode = $crawler->selectButton('Submit');
        $form = $buttonCrawlerNode->form();
        $form->setValues(array(
            'article[name]' => "articleEdit",
            'article[heading]' => "articleEdit heading",
            'article[content]' => "articleEdit content",
        ));
        $crawler = $client->submit($form);
        $this->assertEquals(1, $crawler->filter('.panel tbody tr')->count());
        $this->assertEquals("articleEdit", trim($crawler->filter('.panel td')->eq(1)->text()));
    }

    /**
     * Test remove article
     */
    public function testRemove()
    {
        $client = static::createClient();
        $client->followRedirects(true);
        $crawler = $client->request('GET', '/article/remove//cms/page/blog/articleEdit');
        $this->assertEquals(0, $crawler->filter('.panel tbody tr')->count());
    }
}