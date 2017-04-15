<?php

namespace mssimi\ContentManagementBundle\Repository;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ArticleRepository
 * @package mssimi\ContentManagementBundle\Repository
 * @author Marek Šimeček <mssimi@seznam.cz>
 */
class ArticleRepository extends \Doctrine\ODM\PHPCR\DocumentRepository
{
    /**
     * Article pagination query
     *
     * @param Request $request
     * @return mixed
     */
    public function pagination(Request $request)
    {
        $qb =  $this->createQueryBuilder('Article');
        $qb->where()->child($request->query->get('parent'), 'Article');

        if($request->query->has('nodeName')){
            $qb->where()->like()->localName('Article')->literal('%'.$request->query->get('nodeName').'%');
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
        $qb = $this->createQueryBuilder('Article');
        $qb->where()->like()->localName('Article')->literal('%'.$name.'%');
        $qb->setMaxResults($limit);
        return $qb->getQuery()->execute();
    }
}
