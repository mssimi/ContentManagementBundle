<?php

namespace mssimi\ContentManagementBundle\DataCollector;

use mssimi\ContentManagementBundle\Twig\BlockTwigExtension;
use Symfony\Component\HttpKernel\DataCollector\DataCollector;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BlockDataCollector extends DataCollector
{
    private $profile;

    public function __construct(BlockTwigExtension $profile)
    {
        $this->profile = $profile;
    }

    public function collect(Request $request, Response $response, \Exception $exception = null)
    {
        $this->data = $this->profile->getProfile();
    }

    public function getName()
    {
        return 'content_management.block_collector';
    }

    public function  getProfile()
    {
        return $this->data;
    }

    public function getBlockCount(){
        return count($this->data['nodes']);
    }

    public function getBlockCalled(){
        return $this->data['nodes'];
    }

    public function getStatus(){
        return $this->data['status'];
    }
}