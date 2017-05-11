<?php

namespace mssimi\ContentManagementBundle\Repository;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class MenuRepository
 * @package mssimi\ContentManagementBundle\Repository
 * @author Marek Šimeček <mssimi@seznam.cz>
 */
class BlogRepository extends \Doctrine\ODM\PHPCR\DocumentRepository
{
    /**
     * Blog pagination query
     *
     * @param Request $request
     * @return mixed
     */
    public function pagination(Request $request)
    {
        $qb =  $this->createQueryBuilder('Blog');

        if($request->query->has('nodeName')){
            $qb->where()->like()->localName('Blog')->literal('%'.$request->query->get('nodeName').'%');
        }

        return $qb->getQuery();
    }

    /**
     * Finds where like %nodename%
     *
     * @param $name
     * @param null $limit
     * @return mixed
     */
    public function findLikeNodename($name, $limit = null){
        $qb = $this->createQueryBuilder('Blog');
        $qb->where()->like()->localName('Blog')->literal('%'.$name.'%');
        $qb->setMaxResults($limit);
        return $qb->getQuery()->execute();
    }
}
