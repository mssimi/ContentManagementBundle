<?php

namespace mssimi\ContentManagementBundle\Repository;

/**
 * BlockRepository
 *
 */
class BlockRepository extends \Doctrine\ODM\PHPCR\DocumentRepository
{
    public function findLikeNodename($name){
        $qb = $this->createQueryBuilder('Block');
        $qb->where()->like()->localName('Block')->literal('%'.$name.'%');
        return $qb->getQuery()->execute();
    }
}
