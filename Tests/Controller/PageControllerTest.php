<?php

namespace mssimi\ContentManagementBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PageControllerTest extends WebTestCase
{
    public function testIndexAction()
    {
        $client = static::createClient();
        $client->request('GET', '/page/index');
        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    /**
     * Test new page
     */
    public function testNewSave()
    {
        $client = static::createClient();
        $client->followRedirects(true);
        $crawler = $client->request('GET', '/page/new');
        $buttonCrawlerNode = $crawler->selectButton('Submit');
        $form = $buttonCrawlerNode->form();
        $form->setValues(array(
            'page[name]' => "pageCreate",
            'page[heading]' => "pageCreate heading",
            'page[content]' => "pageCreate content",
        ));
        $crawler = $client->submit($form);
        $this->assertEquals(1, $crawler->filter('.panel tbody tr')->count());
        $this->assertEquals("pageCreate", trim($crawler->filter('.panel td')->eq(1)->text()));
    }

    /**
     * Test edit page
     */
    public function testEditSave()
    {
        $client = static::createClient();
        $client->followRedirects(true);
        $crawler = $client->request('GET', '/page/edit//cms/page/pageCreate');
        $buttonCrawlerNode = $crawler->selectButton('Submit');
        $form = $buttonCrawlerNode->form();
        $form->setValues(array(
            'page[name]' => "pageEdit",
            'page[heading]' => "pageEdit heading",
            'page[content]' => "pageEdit content",
        ));
        $crawler = $client->submit($form);
        $this->assertEquals(1, $crawler->filter('.panel tbody tr')->count());
        $this->assertEquals("pageEdit", trim($crawler->filter('.panel td')->eq(1)->text()));
    }

    public function testPageAction()
    {
        $client = static::createClient();
        $client->request('GET', '/pageEdit');
        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    /**
     * Test remove page
     */
    public function testRemove()
    {
        $client = static::createClient();
        $client->followRedirects(true);
        $crawler = $client->request('GET', '/page/remove//cms/page/pageEdit');
        $this->assertEquals(0, $crawler->filter('.panel tbody tr')->count());
    }
}