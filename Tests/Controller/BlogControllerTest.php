<?php

namespace mssimi\ContentManagementBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BlogControllerTest extends WebTestCase
{
    public function testIndexAction()
    {
        $client = static::createClient();
        $client->request('GET', '/blog/index');
        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    /**
     * Test new blog
     */
    public function testNewSave()
    {
        $client = static::createClient();
        $client->followRedirects(true);
        $crawler = $client->request('GET', '/blog/new');
        $buttonCrawlerNode = $crawler->selectButton('Submit');
        $form = $buttonCrawlerNode->form();
        $form->setValues(array(
            'blog[name]' => "blogCreate",
            'blog[heading]' => "blogCreate heading",
            'blog[content]' => "blogCreate content",
        ));
        $crawler = $client->submit($form);
        $this->assertEquals(1, $crawler->filter('.panel tbody tr')->count());
        $this->assertEquals("blogCreate", trim($crawler->filter('.panel td')->eq(1)->text()));
    }

    /**
     * Test edit blog
     */
    public function testEditSave()
    {
        $client = static::createClient();
        $client->followRedirects(true);
        $crawler = $client->request('GET', '/blog/edit//cms/page/blogCreate');
        $buttonCrawlerNode = $crawler->selectButton('Submit');
        $form = $buttonCrawlerNode->form();
        $form->setValues(array(
            'blog[name]' => "blogEdit",
            'blog[heading]' => "blogEdit heading",
            'blog[content]' => "blogEdit content",
        ));
        $crawler = $client->submit($form);
        $this->assertEquals(1, $crawler->filter('.panel tbody tr')->count());
        $this->assertEquals("blogEdit", trim($crawler->filter('.panel td')->eq(1)->text()));
    }

    /**
     * Test remove blog
     */
    public function testRemove()
    {
        $client = static::createClient();
        $client->followRedirects(true);
        $crawler = $client->request('GET', '/blog/remove//cms/page/blogEdit');
        $this->assertEquals(0, $crawler->filter('.panel tbody tr')->count());
    }
}