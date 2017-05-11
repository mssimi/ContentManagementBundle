<?php

namespace mssimi\ContentManagementBundle\Repository;

/**
 * Class AbstractPageRepository
 * @package mssimi\ContentManagementBundle\Repository
 * @author Marek Šimeček <mssimi@seznam.cz>
 */
class AbstractPageRepository extends \Doctrine\ODM\PHPCR\DocumentRepository
{
    /**
     * Finds where like %nodename%
     *
     * @param $name
     * @param null $limit
     * @return mixed
     */
    public function findLikeNodename($name, $limit = null){
        $qb = $this->createQueryBuilder('Page');
        $qb->where()->like()->localName('Page')->literal('%'.$name.'%');
        $qb->setMaxResults($limit);
        return $qb->getQuery()->execute();
    }
}
