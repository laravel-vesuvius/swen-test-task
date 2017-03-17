<?php

namespace AppBundle\Repository;


use Doctrine\ORM\QueryBuilder;

/**
 * Trait Pagination
 *
 * @package AppBundle\Repository
 */
trait Pagination
{
    /**
     * @param int|bool $limit
     * @param int|bool $offset
     *
     * @return array
     */
    public function findPaginated($limit = false, $offset = false)
    {
        $builder = $this->createQueryBuilder('items');

        if ($limit) {
            $builder->setMaxResults($limit);
        }

        if ($offset) {
            $builder->setFirstResult($offset);
        }

        return $builder->getQuery()->getResult();
    }

    /**
     * @param $alias
     * @param null $indexBy
     *
     * @return QueryBuilder
     */
    abstract function createQueryBuilder($alias, $indexBy = null);
}
