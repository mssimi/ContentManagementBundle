<?php

namespace mssimi\ContentManagementBundle\Repository;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class MenuRepository
 * @package mssimi\ContentManagementBundle\Repository
 * @author Marek Šimeček <mssimi@seznam.cz>
 */
class MenuRepository extends \Doctrine\ODM\PHPCR\DocumentRepository
{
    /**
     * Menu pagination query
     *
     * @param Request $request
     * @return mixed
     */
    public function pagination(Request $request){
        $qb =  $this->createQueryBuilder('Menu');
        //$qb->where()->child('/cms/menu','Menu');

        if($request->query->has('nodeName')){
            $qb->where()->like()->localName('Menu')->literal('%'.$request->query->get('nodeName').'%');
        }

        return $qb->getQuery();
    }
}
