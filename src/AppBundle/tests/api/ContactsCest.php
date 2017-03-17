<?php

namespace AppBundle;


use AppBundle\Entity\Contact;
use Codeception\Util\HttpCode;

class ContactsCest
{
    public function getContactTest(ApiTester $I)
    {
        $contact = $I->have(Contact::class);
        $I->wantTo('see contact in response');
        $I->sendGET('/contacts/' . $contact->getId());

        $I->seeResponseContainsJson([
            'contact' => [
                'id' => $contact->getId(),
                'salutation' => $contact->getSalutation(),
                'first_name' => $contact->getFirstName(),
                'last_name' => $contact->getLastName(),
                'mail' => $contact->getMail(),
            ],
        ]);
    }

    public function putContactTest(ApiTester $I)
    {
        $contact = $I->have(Contact::class);
        $url = '/contacts/' . $contact->getId();

        $I->wantTo('update contact and see response');
        $I->sendPUT($url, []);
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);

        $contactData = [
            'salutation' => 'test',
            'first_name' => 'test',
            'last_name' => 'test',
            'mail' => 'test',
        ];
        $data = ['contact' => $contactData];
        $I->sendPUT($url, $data);
        $I->seeInRepository(Contact::class, [
            'id' => $contact->getId(),
            'salutation' => $contactData['salutation'],
            'firstName' => $contactData['first_name'],
            'lastName' => $contactData['last_name'],
            'mail' => $contactData['mail'],
        ]);
        $I->seeResponseContainsJson([
            'contact' => [
                'id' => $contact->getId(),
                'salutation' => $contactData['salutation'],
                'first_name' => $contactData['first_name'],
                'last_name' => $contactData['last_name'],
                'mail' => $contactData['mail'],
            ],
        ]);
    }

    public function deleteContactTest(ApiTester $I)
    {
        $contact = $I->have(Contact::class);
        $url = '/contacts/' . $contact->getId();

        $I->wantTo('delete contact and see blank response');
        $I->sendDELETE($url);

        $I->dontSeeInRepository(Contact::class, ['id' => $contact->getId()]);
        $I->seeResponseContainsJson([]);
    }
}
