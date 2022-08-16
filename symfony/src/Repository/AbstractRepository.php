<?php

namespace AppBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Pagerfanta\Doctrine\Collections\CollectionAdapter;
use Pagerfanta\Pagerfanta;

/**
 * @extends ServiceEntityRepository
 *
 */
abstract class AbstractRepository extends ServiceEntityRepository
{
    protected function paginate(CollectionAdapter $adapter, $limit = 20, $offset = 0)
    {
        if(0 == $limit || 0 == $offset){
            throw new \LogicException('$limit & $offset must be greater than 0.');
        }

        $pager = new Pagerfanta($adapter);
        $currentPage = ceil(($offset + 1)/$limit);
        $pager->setCurrentPage($currentPage);
        $pager->setMaxPerPage((int) $limit);
        return $pager;
    }
}