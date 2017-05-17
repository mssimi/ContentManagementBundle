<?php

namespace mssimi\ContentManagementBundle\Tests\Controller;

use mssimi\ContentManagementBundle\Document\Menu;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MenuItemControllerTest extends WebTestCase
{
    public static function setUpBeforeClass()
    {
        $client = static::createClient();
        $container = $client->getContainer();
        $dm = $container->get('doctrine_phpcr')->getManager();

        $parent = $dm->find(null, '/cms/menu');

        $menu = new Menu();
        $menu->setParent($parent);
        $menu->setName('menu');

        $dm->persist($menu);
        $dm->flush();
    }

    public static function tearDownAfterClass()
    {
        $client = static::createClient();
        $container = $client->getContainer();
        $dm = $container->get('doctrine_phpcr')->getManager();

        $menu = $dm->find(null, '/cms/menu/menu');

        $dm->remove($menu);
        $dm->flush();
    }

    public function testIndexAction()
    {
        $client = static::createClient();
        $client->request('GET', '/menu-item/index//cms/menu/menu');
        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    /**
     * Test new menu item
     */
    public function testNewSave()
    {
        $client = static::createClient();
        $client->followRedirects(true);
        $crawler = $client->request('GET', '/menu-item/new//cms/menu/menu');
        $buttonCrawlerNode = $crawler->selectButton('Submit');
        $form = $buttonCrawlerNode->form();

        $form->setValues(array(
            'menu_item[label]' => "menuItemCreate label",
            'menu_item[link]' => "https://google.com",
            'menu_item[linkType]' => "url",
        ));
        $crawler = $client->submit($form);
        $this->assertEquals(1, $crawler->filter('ul.sortable')->count());
    }

    /**
     * Test edit menu item
     */
    public function testEditSave()
    {
        $client = static::createClient();
        $client->followRedirects(true);
        $crawler = $client->request('GET', '/menu-item/edit/' . $this->getId());
        $buttonCrawlerNode = $crawler->selectButton('Submit');
        $form = $buttonCrawlerNode->form();
        $form->setValues(array(
            'menu_item[label]' => "menuItemEdit label",
        ));

        $crawler = $client->submit($form);
        $this->assertEquals(1, $crawler->filter('ul.sortable')->count());
    }

    /**
     * Test remove menu item
     */
    public function testRemove()
    {
        $client = static::createClient();
        $client->followRedirects(true);
        $crawler = $client->request('GET', '/menu-item/remove/' . $this->getId());
        $this->assertEquals(0, $crawler->filter('.panel tbody tr')->count());
    }

    public function getId(){
        $client = static::createClient();
        $container = $client->getContainer();
        $dm = $container->get('doctrine_phpcr')->getManager();

        $menu = $dm->find(null, '/cms/menu/menu');
        return $menu->getChildren()->first()->getId();
    }
}