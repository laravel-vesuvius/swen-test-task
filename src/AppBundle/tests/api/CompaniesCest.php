<?php

namespace AppBundle;


use AppBundle\Entity\Company;
use AppBundle\Entity\Contact;
use Codeception\Util\HttpCode;

class CompaniesCest
{
    public function getCompanyTest(ApiTester $I)
    {
        $company = $I->have(Company::class);
        $I->wantTo('see company in response');
        $I->sendGET('/companies/' . $company->getId());

        $I->seeResponseContainsJson([
            'company' => [
                'id' => $company->getId(),
                'name' => $company->getName(),
                'customer_no' => $company->getCustomerNo()
            ]
        ]);
    }

    public function postCompanyTest(ApiTester $I)
    {
        $I->wantTo('create company and see response');
        $I->sendPOST('/companies', []);
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);

        $data = ['company' => ['name' => 'test', 'customerNo' => 1]];
        $I->sendPOST('/companies', $data);
        $id = $I->grabFromRepository(Company::class, 'id', ['name' => 'test']);
        $I->seeResponseContainsJson([
            'company' => [
                'id' => $id,
                'name' => $data['company']['name'],
                'customer_no' => $data['company']['customerNo']
            ]
        ]);
    }

    public function putCompanyTest(ApiTester $I)
    {
        $company = $I->have(Company::class);
        $url = '/companies/' . $company->getId();

        $I->wantTo('update company and see response');
        $I->sendPUT($url, []);
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);

        $data = ['company' => ['name' => 'new_test', 'customerNo' => 1]];
        $I->sendPUT($url, $data);
        $I->seeInRepository(Company::class, ['id' => $company->getId(), 'name' => 'new_test']);
        $I->seeResponseContainsJson([
            'company' => [
                'id' => $company->getId(),
                'name' => $data['company']['name'],
                'customer_no' => $data['company']['customerNo']
            ]
        ]);
    }

    public function deleteCompanyTest(ApiTester $I)
    {
        $company = $I->have(Company::class);
        $url = '/companies/' . $company->getId();

        $I->wantTo('delete company and see blank response');
        $I->sendDELETE($url);

        $I->dontSeeInRepository(Company::class, ['id' => $company->getId()]);
        $I->seeResponseContainsJson([]);
    }

    public function getCompaniesTest(ApiTester $I)
    {
        $I->haveMultiple(Company::class, 3);
        $I->wantTo('see companies in response');
        $I->sendGET('/companies');

        $I->seeResponseJsonMatchesXpath('//companies');
        $I->seeResponseJsonMatchesXpath('//offset');
        $I->seeResponseJsonMatchesXpath('//limit');
    }

    public function getCompanyContactsTest(ApiTester $I)
    {
        $contact = $I->have(Contact::class);

        $I->wantTo('see company contacts in response');
        $I->sendGET("/companies/{$contact->getCompany()->getId()}/contacts");

        $I->seeResponseJsonMatchesXpath('//contacts');
        $I->seeResponseJsonMatchesXpath('//offset');
        $I->seeResponseJsonMatchesXpath('//limit');
    }

    public function postCompanyContactTest(ApiTester $I)
    {
        $company = $I->have(Company::class);
        $url = "/companies/{$company->getId()}/contacts";

        $I->wantTo('create contact and see response');
        $I->sendPOST($url, []);
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);

        $data = [
            'contact' => [
                'salutation' => 'test',
                'firstName' => 'test',
                'lastName' => 'test',
                'mail' => 'test',
            ],
        ];
        $I->sendPOST($url, $data);
        $id = $I->grabFromRepository(Contact::class, 'id', ['salutation' => 'test']);
        $I->seeResponseContainsJson([
            'contact' => [
                'id' => $id,
                'salutation' => $data['contact']['salutation'],
                'first_name' => $data['contact']['firstName'],
                'last_name' => $data['contact']['lastName'],
                'mail' => $data['contact']['mail'],
            ],
        ]);
    }
}
