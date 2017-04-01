<?php

namespace mssimi\ContentManagementBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BlockControllerTest extends WebTestCase
{
    public function testIndexAction()
    {
        $client = static::createClient();
        $client->request('GET', '/block/index');
        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    /**
     * Test new block
     */
    public function testNewSave()
    {
        $client = static::createClient();
        $client->followRedirects(true);
        $crawler = $client->request('GET', '/block/new');
        $buttonCrawlerNode = $crawler->selectButton('Submit');
        $form = $buttonCrawlerNode->form();
        $form->setValues(array(
            'block[name]' => "blockCreate",
            'block[content]' => "blockCreate content",
        ));
        $crawler = $client->submit($form);
        $this->assertEquals(1, $crawler->filter('.panel tbody tr')->count());
        $this->assertEquals("blockCreate", trim($crawler->filter('.panel td')->eq(0)->text()));
    }

    /**
     * Test edit block
     */
    public function testEditSave()
    {
        $client = static::createClient();
        $client->followRedirects(true);
        $crawler = $client->request('GET', '/block/edit//cms/block/blockCreate');
        $buttonCrawlerNode = $crawler->selectButton('Submit');
        $form = $buttonCrawlerNode->form();
        $form->setValues(array(
            'block[name]' => "blockEdit",
            'block[content]' => "blockEdit content",
        ));
        $crawler = $client->submit($form);
        $this->assertEquals(1, $crawler->filter('.panel tbody tr')->count());
        $this->assertEquals("blockEdit", trim($crawler->filter('.panel td')->eq(0)->text()));
    }
}