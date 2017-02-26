<?php

namespace mssimi\ContentManagementBundle\Repository;

/**
 * Class BlockRepository
 * @package mssimi\ContentManagementBundle\Repository
 * @author Marek Šimeček <mssimi@seznam.cz>
 */
class BlockRepository extends \Doctrine\ODM\PHPCR\DocumentRepository
{
    /**
     * Finds block where like %nodename%
     *
     * @param $name
     * @return mixed
     */
    public function findLikeNodename($name){
        $qb = $this->createQueryBuilder('Block');
        $qb->where()->like()->localName('Block')->literal('%'.$name.'%');
        return $qb->getQuery()->execute();
    }
}
