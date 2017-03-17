<?php

namespace AppBundle\Repository;


use AppBundle\Entity\Company;

/**
 * Class ContactRepository
 *
 * @package AppBundle\Repository
 */
class ContactRepository extends \Doctrine\ORM\EntityRepository
{
    use Pagination;

    /**
     * @param Company $company
     * @param int|bool $limit
     * @param int|bool $offset
     *
     * @return array
     */
    public function findPaginatedForCompany(Company $company, $limit = false, $offset = false)
    {
        $builder = $this->createQueryBuilder('contacts')
            ->join('contacts.company', 'company')
            ->where('company.id = :company')
            ->setParameter('company', $company);

        $this->addPagination($builder, $limit, $offset);

        return $builder->getQuery()->getResult();
    }
}
