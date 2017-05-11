<?php

namespace mssimi\ContentManagementBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SliderControllerTest extends WebTestCase
{
    public function testIndexAction()
    {
        $client = static::createClient();
        $client->request('GET', '/slider/index');
        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    /**
     * Test new slider
     */
    public function testNewSave()
    {
        $client = static::createClient();
        $client->followRedirects(true);
        $crawler = $client->request('GET', '/slider/new');
        $buttonCrawlerNode = $crawler->selectButton('Submit');
        $form = $buttonCrawlerNode->form();
        $form->setValues(array(
            'slider[name]' => "sliderCreate",
        ));
        $crawler = $client->submit($form);
        $this->assertEquals(1, $crawler->filter('.panel tbody tr')->count());
        $this->assertEquals("sliderCreate", trim($crawler->filter('.panel td')->eq(1)->text()));
    }

    /**
     * Test edit slider
     */
    public function testEditSave()
    {
        $client = static::createClient();
        $client->followRedirects(true);
        $crawler = $client->request('GET', '/slider/edit//cms/slider/sliderCreate');
        $buttonCrawlerNode = $crawler->selectButton('Submit');
        $form = $buttonCrawlerNode->form();
        $form->setValues(array(
            'slider[name]' => "sliderEdit",
        ));
        $crawler = $client->submit($form);
        $this->assertEquals(1, $crawler->filter('.panel tbody tr')->count());
        $this->assertEquals("sliderEdit", trim($crawler->filter('.panel td')->eq(1)->text()));
    }

    /**
     * Test remove slider
     */
    public function testRemove()
    {
        $client = static::createClient();
        $client->followRedirects(true);
        $crawler = $client->request('GET', '/slider/remove//cms/slider/sliderEdit');
        $this->assertEquals(0, $crawler->filter('.panel tbody tr')->count());
    }
}