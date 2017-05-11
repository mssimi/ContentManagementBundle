<?php

namespace mssimi\ContentManagementBundle\DataCollector;

use mssimi\ContentManagementBundle\Twig\BlockTwigExtension;
use Symfony\Component\HttpKernel\DataCollector\DataCollector;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BlockDataCollector extends DataCollector
{
    private $profile;

    /**
     * BlockDataCollector constructor.
     * @param BlockTwigExtension $profile
     */
    public function __construct(BlockTwigExtension $profile)
    {
        $this->profile = $profile;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param \Exception|null $exception
     */
    public function collect(Request $request, Response $response, \Exception $exception = null)
    {
        $this->data = $this->profile->getProfile();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'content_management.block_collector';
    }

    /**
     * @return array
     */
    public function  getProfile()
    {
        return $this->data;
    }

    /**
     * @return int
     */
    public function getBlockCount(){
        return count($this->data['nodes']);
    }

    /**
     * @return mixed
     */
    public function getBlockCalled(){
        return $this->data['nodes'];
    }

    /**
     * @return mixed
     */
    public function getStatus(){
        return $this->data['status'];
    }
}