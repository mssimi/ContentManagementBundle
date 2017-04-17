<?php

namespace mssimi\ContentManagementBundle\Repository;

use Symfony\Component\HttpFoundation\Request;

/**
 * Class GalleryImageRepository
 * @package mssimi\ContentManagementBundle\Repository
 * @author Marek Šimeček <mssimi@seznam.cz>
 */
class GalleryImageRepository extends \Doctrine\ODM\PHPCR\DocumentRepository
{
    /**
     * Page pagination query
     *
     * @param Request $request
     * @return mixed
     */
    public function pagination(Request $request)
    {
        $qb =  $this->createQueryBuilder('GalleryImage');
        $qb->where()->child($request->query->get('parent'), 'GalleryImage');

        if($request->query->has('nodeName')){
            $qb->where()->like()->localName('GalleryImage')->literal('%'.$request->query->get('nodeName').'%');
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
        $qb = $this->createQueryBuilder('GalleryImage');
        $qb->where()->like()->localName('GalleryImage')->literal('%'.$name.'%');
        $qb->setMaxResults($limit);
        return $qb->getQuery()->execute();
    }
}
