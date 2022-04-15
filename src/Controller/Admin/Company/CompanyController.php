<?php

namespace App\Controller\Admin\Company;

use App\Entity\Company;
use App\Form\CompanyEditType;
use App\Repository\CompanyRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/Admin/Companies', name: 'admin_company')]
class CompanyController extends AbstractController
{
    public function __construct(
        private ManagerRegistry $doctrine,
        private CompanyRepository $companyRepository,
    ) {}

    #[Route('/', name: '_index')]
    public function index(): Response
    {
        return $this->render(
            'admin/company/index.html.twig',
            [
                'companies' => $this->companyRepository->findBy([], ['name' => 'ASC']),
            ]
        );
    }

    #[Route('/new', name: '_create')]
    public function create(Request $request): Response
    {
        $company = new Company();
        $form = $this->createForm(CompanyEditType::class, $company);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->doctrine->getManager()->persist($company);
            $this->doctrine->getManager()->flush();

            return $this->redirectToRoute('admin_company_index');
        }

        return $this->render(
            'admin/company/edit.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }

    #[Route('/{id}', name: '_view')]
    public function view(int $id): Response
    {
        return $this->render(
            'admin/company/view.html.twig',
            [
                'company' => $this->companyRepository->find($id),
            ]
        );
    }

    #[Route('/update/{id}', name: '_update')]
    public function update(int $id, Request $request): Response
    {
        $company = $this->companyRepository->find($id);
        $form = $this->createForm(CompanyEditType::class, $company);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->doctrine->getManager()->flush();

            return $this->redirectToRoute('admin_company_view', ['id' => $id]);
        }

        return $this->render(
            'admin/company/edit.html.twig',
            [
                'form' => $form->createView(),
                'company' => $company,
            ]
        );
    }

    #[Route('/changeStatus/{id}', name: '_change_status')]
    public function changeStatus(int $id): RedirectResponse
    {
        $company = $this->companyRepository->find($id);
        $company->setIsActive(!$company->getIsActive());
        $this->doctrine->getManager()->flush();

        return $this->redirectToRoute('admin_company_view', ['id' => $id]);
    }

    #[Route('/delete/{id}', name: '_delete')]
    public function delete(int $id): RedirectResponse
    {
        $company = $this->companyRepository->find($id);
        $this->doctrine->getManager()->remove($company);
        $this->doctrine->getManager()->flush();

        return $this->redirectToRoute('admin_company_index');
    }
}
