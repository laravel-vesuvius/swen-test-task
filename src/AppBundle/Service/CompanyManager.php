<?php

namespace AppBundle\Service;


use AppBundle\Entity\Company;
use AppBundle\Model\CompaniesPaginatedResult;
use Doctrine\ORM\EntityManager;

/**
 * Class CompanyManager
 *
 * @package AppBundle\Serializer
 */
class CompanyManager
{
    /**
     * @var EntityManager
     */
    protected $em;


    /**
     * CompanyManager constructor.
     *
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param $limit
     * @param $offset
     *
     * @return CompaniesPaginatedResult
     */
    public function paginate($limit, $offset)
    {
        $result = $this->em->getRepository('AppBundle:Company')->findPaginated($limit, $offset);

        return new CompaniesPaginatedResult($result, $limit, $offset);
    }

    /**
     * @param Company $company
     */
    public function update(Company $company)
    {
        $this->em->persist($company);
        $this->em->flush();
    }
}
