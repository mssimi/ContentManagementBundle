<?php

namespace mssimi\ContentManagementBundle\Repository;

use Symfony\Component\HttpFoundation\Request;

/**
 * Class SliderImageRepository
 * @package mssimi\ContentManagementBundle\Repository
 * @author Marek Šimeček <mssimi@seznam.cz>
 */
class SliderImageRepository extends \Doctrine\ODM\PHPCR\DocumentRepository
{
    /**
     * Page pagination query
     *
     * @param Request $request
     * @return mixed
     */
    public function pagination(Request $request)
    {
        $qb =  $this->createQueryBuilder('SliderImage');

        if($request->query->has('nodeName')){
            $qb->where()->like()->localName('SliderImage')->literal('%'.$request->query->get('nodeName').'%');
        }

        return $qb->getQuery();
    }

    /**
     * Finds block where like %nodename%
     *
     * @param $name
     * @param null $limit
     * @return mixed
     */
    public function findLikeNodename($name, $limit = null){
        $qb = $this->createQueryBuilder('SliderImage');
        $qb->where()->like()->localName('SliderImage')->literal('%'.$name.'%');
        $qb->setMaxResults($limit);
        return $qb->getQuery()->execute();
    }
}
