<?php

namespace AppBundle\Service;


use AppBundle\Entity\Company;
use AppBundle\Entity\Contact;
use AppBundle\Model\ContactsPaginatedResult;
use Doctrine\ORM\EntityManager;

/**
 * Class ContactManager
 *
 * @package AppBundle\Serializer
 */
class ContactManager
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
     * @param Company $company
     * @param $limit
     * @param $offset
     *
     * @return ContactsPaginatedResult
     */
    public function paginateForCompany(Company $company, $limit, $offset)
    {
        $result = $this->em->getRepository('AppBundle:Contact')->findPaginatedForCompany($company, $limit, $offset);

        return new ContactsPaginatedResult($result, $limit, $offset);
    }

    /**
     * @param Contact $contact
     */
    public function update(Contact $contact)
    {
        $this->em->persist($contact);
        $this->em->flush();
    }
}
