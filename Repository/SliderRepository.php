<?php

namespace mssimi\ContentManagementBundle\Repository;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class SliderRepository
 * @package mssimi\ContentManagementBundle\Repository
 * @author Marek Šimeček <mssimi@seznam.cz>
 */
class SliderRepository extends \Doctrine\ODM\PHPCR\DocumentRepository
{
    /**
     * Slider pagination query
     *
     * @param Request $request
     * @return mixed
     */
    public function pagination(Request $request)
    {
        $qb =  $this->createQueryBuilder('Slider');

        if($request->query->has('nodeName')){
            $qb->where()->like()->localName('Slider')->literal('%'.$request->query->get('nodeName').'%');
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
        $qb = $this->createQueryBuilder('Slider');
        $qb->where()->like()->localName('Slider')->literal('%'.$name.'%');
        $qb->setMaxResults($limit);
        return $qb->getQuery()->execute();
    }
}
