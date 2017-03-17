<?php

use League\FactoryMuffin\Faker\Facade as Faker;
use AppBundle\Entity\Contact as Contact;
use \AppBundle\Entity\Company as Company;

$fm->define(Company::class)->setDefinitions([
    'name' => Faker::name(),
    'customerNo' => Faker::instance()->unique()->numberBetween()
]);

$fm->define(Contact::class)->setDefinitions([
    'salutation' => Faker::word(),
    'firstName' => Faker::name(),
    'lastName' => Faker::lastName(),
    'mail' => Faker::word()
])->setCallback(function (Contact $object, $saved) use ($fm) {
    $company = $fm->create(Company::class);

    $object->setCompany($company);
});
