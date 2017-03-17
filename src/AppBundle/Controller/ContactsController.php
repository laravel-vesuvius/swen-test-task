<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Contact;
use AppBundle\Form\Type\ContactType;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\View\View;

/**
 * Class ContactsController
 *
 * @package AppBundle\Controller
 */
class ContactsController extends FOSRestController
{
    /**
     * @param Contact $contact
     *
     * @return Contact
     */
    public function getContactAction(Contact $contact)
    {
        return compact('contact');
    }

    /**
     * @param Contact $contact
     * @param Request $request
     *
     * @return array|View
     */
    public function putContactAction(Contact $contact, Request $request)
    {
        $form = $this->createForm(ContactType::class, $contact, ['method' => 'PUT']);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->getContactManager()->update($contact);

            return compact('contact');
        }

        return $this->view($form, 422);
    }

    /**
     * @param Contact $contact
     *
     * @return array
     */
    public function deleteContactAction(Contact $contact)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($contact);
        $em->flush();

        return [];
    }

    /**
     * @return \AppBundle\Service\ContactManager
     */
    protected function getContactManager()
    {
        return $this->get('app.contact_manager');
    }
}
