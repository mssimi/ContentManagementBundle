<?php

namespace mssimi\ContentManagementBundle\Repository;

/**
 * Class MenuRepository
 * @package mssimi\ContentManagementBundle\Repository
 * @author Marek Šimeček <mssimi@seznam.cz>
 */
class PageRepository extends \Doctrine\ODM\PHPCR\DocumentRepository
{
    /**
     * Finds block where like %nodename%
     *
     * @param $name
     * @return mixed
     */
    public function findLikeNodename($name){
        $qb = $this->createQueryBuilder('Page');
        $qb->where()->like()->localName('Page')->literal('%'.$name.'%');
        return $qb->getQuery()->execute();
    }
}
