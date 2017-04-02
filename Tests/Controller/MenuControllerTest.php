<?php

namespace mssimi\ContentManagementBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MenuControllerTest extends WebTestCase
{
    public function testIndexAction()
    {
        $client = static::createClient();
        $client->request('GET', '/menu/index');
        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    /**
     * Test new menu
     */
    public function testNewSave()
    {
        $client = static::createClient();
        $client->followRedirects(true);
        $crawler = $client->request('GET', '/menu/new');
        $buttonCrawlerNode = $crawler->selectButton('Submit');
        $form = $buttonCrawlerNode->form();
        $form->setValues(array(
            'menu[name]' => "menuCreate",
            'menu[label]' => "menuCreate label",
            'menu[link]' => "http://www.google.com",
            'menu[linkType]' => "url",
        ));
        $crawler = $client->submit($form);
        $this->assertEquals(1, $crawler->filter('.panel tbody tr')->count());
        $this->assertEquals("menuCreate", trim($crawler->filter('.panel td .folder')->eq(0)->text()));
    }

    /**
     * Test edit menu
     */
    public function testEditSave()
    {
        $client = static::createClient();
        $client->followRedirects(true);
        $crawler = $client->request('GET', '/menu/edit//cms/menu/menuCreate');
        $buttonCrawlerNode = $crawler->selectButton('Submit');
        $form = $buttonCrawlerNode->form();
        $form->setValues(array(
            'menu[name]' => "menuEdit",
            'menu[label]' => "menuEdit label",
            'menu[link]' => "http://www.google.com",
            'menu[linkType]' => "url",
        ));
        $crawler = $client->submit($form);
        $this->assertEquals(1, $crawler->filter('.panel tbody tr')->count());
        $this->assertEquals("menuEdit", trim($crawler->filter('.panel td .folder')->eq(0)->text()));
    }
}