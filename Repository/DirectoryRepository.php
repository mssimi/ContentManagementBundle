<?php

namespace mssimi\ContentManagementBundle\Repository;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class DirectoryRepository
 * @package mssimi\ContentManagementBundle\Repository
 * @author Marek Šimeček <mssimi@seznam.cz>
 */
class DirectoryRepository extends \Doctrine\ODM\PHPCR\DocumentRepository
{
    /**
     * Page pagination query
     *
     * @param Request $request
     * @return mixed
     */
    public function pagination(Request $request){
        $qb =  $this->createQueryBuilder('Directory');

        if($request->query->has('nodeName')){
            $qb->where()->like()->localName('Directory')->literal('%'.$request->query->get('nodeName').'%');
        }

        return $qb->getQuery();
    }
}
