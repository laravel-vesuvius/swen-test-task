<?php

namespace AppBundle\Model;


use Doctrine\ORM\Mapping as ORM;

/**
 * Class PaginatedResult
 *
 * @package AppBundle\Model
 */
class PaginatedResult
{
    /**
     * @var array
     */
    public $collection;

    /**
     * @var int
     */
    public $limit;

    /**
     * @var int
     */
    public $offset;


    /**
     * PaginatedResult constructor.
     *
     * @param array $collection
     * @param int $limit
     * @param int $offset
     */
    public function __construct(array $collection, $limit, $offset)
    {
        $this->collection = $collection;
        $this->limit = $limit;
        $this->offset = $offset;
    }
}
