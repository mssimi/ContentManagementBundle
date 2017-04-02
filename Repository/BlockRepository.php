<?php

namespace mssimi\ContentManagementBundle\Repository;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class BlockRepository
 * @package mssimi\ContentManagementBundle\Repository
 * @author Marek Šimeček <mssimi@seznam.cz>
 */
class BlockRepository extends \Doctrine\ODM\PHPCR\DocumentRepository
{
    /**
     * Block pagination query
     *
     * @param Request $request
     * @return mixed
     */
    public function pagination(Request $request){
        $qb =  $this->createQueryBuilder('Block');

        if($request->query->has('nodeName')){
            $qb->where()->like()->localName('Block')->literal('%'.$request->query->get('nodeName').'%');
        }

        return $qb->getQuery();
    }
}
