<?php

namespace AppBundle\Controller;


use AppBundle\Form\Type\CompanyType;
use FOS\RestBundle\Controller\Annotations as Rest;
use AppBundle\Entity\Company;
use AppBundle\Model\PaginatedResult;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\View\View;

/**
 * Class CompaniesController
 *
 * @package AppBundle\Controller
 */
class CompaniesController extends FOSRestController
{
    /**
     * @param Company $company
     *
     * @return Company
     */
    public function getCompanyAction(Company $company)
    {
        return compact('company');
    }

    /**
     * @Rest\QueryParam(name="offset", requirements="\d+", default=0, description="Offset")
     * @Rest\QueryParam(name="limit", requirements="\d+", default="5", description="Limit")
     *
     * @param ParamFetcherInterface $paramFetcher
     * @return PaginatedResult
     */
    public function getCompaniesAction(ParamFetcherInterface $paramFetcher)
    {
        return $this->getCompanyManager()->paginate($paramFetcher->get('limit'), $paramFetcher->get('offset'));
    }

    /**
     * @param Request $request
     *
     * @return array|View
     */
    public function postCompanyAction(Request $request)
    {
        $company = new Company();

        $form = $this->createForm(CompanyType::class, $company);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->getCompanyManager()->update($company);

            return compact('company');
        }

        return $this->view($form, 422);
    }

    /**
     * @param Company $company
     * @param Request $request
     *
     * @return array|View
     */
    public function putCompanyAction(Company $company, Request $request)
    {
        $form = $this->createForm(CompanyType::class, $company, ['method' => 'PUT']);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->getCompanyManager()->update($company);

            return compact('company');
        }

        return $this->view($form, 422);
    }

    /**
     * @param Company $company
     *
     * @return array
     */
    public function deleteCompanyAction(Company $company)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($company);
        $em->flush();

        return [];
    }

    /**
     * @return \AppBundle\Service\CompanyManager
     */
    protected function getCompanyManager()
    {
        return $this->get('app.company_manager');
    }
}
