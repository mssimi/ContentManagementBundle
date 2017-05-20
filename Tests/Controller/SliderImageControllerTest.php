<?php

namespace mssimi\ContentManagementBundle\Tests\Controller;

use mssimi\ContentManagementBundle\Document\Slider;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class SliderImageControllerTest extends WebTestCase
{
    public static function setUpBeforeClass()
    {
        $client = static::createClient();
        $container = $client->getContainer();
        $dm = $container->get('doctrine_phpcr')->getManager();

        $parent = $dm->find(null, '/cms/slider');

        $slider = new Slider();
        $slider->setParent($parent);
        $slider->setName('slider');

        $dm->persist($slider);
        $dm->flush();
    }

    public static function tearDownAfterClass()
    {
        $client = static::createClient();
        $container = $client->getContainer();
        $dm = $container->get('doctrine_phpcr')->getManager();

        $slider = $dm->find(null, '/cms/slider/slider');

        $dm->remove($slider);
        $dm->flush();
    }

    public function testIndexAction()
    {
        $client = static::createClient();
        $client->request('GET', '/slider-image/index//cms/slider/slider');
        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    /**
     * Test new sliderImage
     */
    public function testNewSave()
    {
        $client = static::createClient();
        $client->followRedirects(true);
        $crawler = $client->request('GET', '/slider-image/new//cms/slider/slider');
        $buttonCrawlerNode = $crawler->selectButton('Submit');
        $form = $buttonCrawlerNode->form();

        $image = new UploadedFile($client->getKernel()->getRootDir().'/dummy.jpg', 'dummy.jpg');

        $form->setValues(array(
            'slider_image[imageFile]' => ['file' => $image],
            'slider_image[link]' => 'http://google.com',
        ));
        $crawler = $client->submit($form);
        $this->assertEquals(1, $crawler->filter('ul.sortable')->count());
    }

    /**
     * Test edit sliderImage
     */
    public function testEditSave()
    {
        $client = static::createClient();
        $client->followRedirects(true);
        $crawler = $client->request('GET', '/slider-image/edit/' . $this->getId());
        $buttonCrawlerNode = $crawler->selectButton('Submit');
        $form = $buttonCrawlerNode->form();
        $form->setValues(array(
        ));
        $crawler = $client->submit($form);
        $this->assertEquals(1, $crawler->filter('ul.sortable')->count());
    }

    /**
     * Test remove sliderImage
     */
    public function testRemove()
    {
        $client = static::createClient();
        $client->followRedirects(true);
        $crawler = $client->request('GET', '/slider-image/remove/' . $this->getId());
        $this->assertEquals(0, $crawler->filter('.panel tbody tr')->count());
    }

    public function getId(){
        $client = static::createClient();
        $container = $client->getContainer();
        $dm = $container->get('doctrine_phpcr')->getManager();

        $blog = $dm->find(null, '/cms/slider/slider');
        return $blog->getChildren()->first()->getId();
    }
}