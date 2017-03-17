<?php

use League\FactoryMuffin\Faker\Facade as Faker;

$fm->define(\AppBundle\Entity\Company::class)->setDefinitions([
    'name' => Faker::name(),
    'customerNo' => Faker::instance()->unique()->numberBetween()
]);
