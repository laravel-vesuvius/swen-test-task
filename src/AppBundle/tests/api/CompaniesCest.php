<?php

namespace AppBundle;


use AppBundle\Entity\Company;
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
}
