<?php

namespace AppBundle\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Company
 *
 * @ORM\Table(name="company")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CompanyRepository")
 * @UniqueEntity("customerNo")
 */
class Company
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="customer_no", type="integer", unique=true)
     * @Assert\NotBlank()
     */
    private $customerNo;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Contact", mappedBy="company")
     * @JMS\Exclude()
     */
    private $contacts;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->contacts = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Company
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set customerNo
     *
     * @param integer $customerNo
     *
     * @return Company
     */
    public function setCustomerNo($customerNo)
    {
        $this->customerNo = $customerNo;

        return $this;
    }

    /**
     * Get customerNo
     *
     * @return int
     */
    public function getCustomerNo()
    {
        return $this->customerNo;
    }

    /**
     * Add contact
     *
     * @param Contact $contact
     *
     * @return Company
     */
    public function addContact(Contact $contact)
    {
        $this->contacts[] = $contact;

        return $this;
    }

    /**
     * Remove contact
     *
     * @param Contact $contact
     */
    public function removeContact(Contact $contact)
    {
        $this->contacts->removeElement($contact);
    }

    /**
     * Get contacts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getContacts()
    {
        return $this->contacts;
    }
}
