<?php

namespace mssimi\ContentManagementBundle\Repository;

/**
 * Class MenuRepository
 * @package mssimi\ContentManagementBundle\Repository
 * @author Marek Šimeček <mssimi@seznam.cz>
 */
class MenuRepository extends \Doctrine\ODM\PHPCR\DocumentRepository
{
    /**
     * Finds menu where like %nodename%
     * @param $name
     * @return mixed
     */
    public function findLikeNodename($name){
        $qb = $this->createQueryBuilder('Menu');
        $qb->where()->like()->localName('Menu')->literal('%'.$name.'%');;
        return $qb->getQuery()->execute();
    }

    /**
     * Finds menu where like id%
     * @param $id
     * @return mixed
     */
    public function findLikeId($id){
        $qb = $this->createQueryBuilder('Menu');
        $qb->where()->descendant($id,'Menu');
        return $qb->getQuery()->execute();
    }
}
