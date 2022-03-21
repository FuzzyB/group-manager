<?php

namespace App\Controller;

use App\Form\FilterCryteria;
use App\Form\PaymentListCriteriaType;
use App\Modules\Payments\Application\PaymentsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PaymentsController extends AbstractController
{
    #[Route("/payments/report", name: 'payments/report')]
    public function index(Request $request, PaymentsService $paymentsService): Response
    {
        $cryteriaForm = new FilterCryteria();

        $cryteriaForm->setAuDate((new \DateTime())->format('Y-m-01'));
        $cryteriaForm->setFilterByColumn($request->query->get('filterColumn') ?? '');
        $cryteriaForm->setFilterText(base64_decode($request->query->get('phrase'))  ?? '');
        $cryteriaForm->setOrderType($request->query->get('sortType') ?? '');
        $cryteriaForm->setSortByColumn($request->query->get('sortBy') ?? '');
        $form = $this->createForm(PaymentListCriteriaType::class, $cryteriaForm);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var FilterCryteria $filterCriteria */
            $filterCriteria = $form->getData();

            return $this->redirectToRoute('payments/report',
                [
                    'show' => '1',
                    'sortBy' => $filterCriteria->getSortByColumn(),
                    'sortType' => $filterCriteria->getOrderType(),
                    'filterColumn' => $filterCriteria->getFilterByColumn(),
                    'phrase' => base64_encode($filterCriteria->getFilterText()),
                ]
            );
        }

        if ($request->query->get('show') === '1') {
            $report = $paymentsService->getSalaryReport($cryteriaForm);
        }

        return $this->renderForm('payment/report.html.twig', [
            'controller_name' => 'PaymentsController',
            'form' => $form,
            'report' => $report ?? [],
        ]);
    }

    /**
     * @param PaymentsService $paymentsService
     * @return Response
     * @throws \Exception
     */
    #[Route('/payments/generate-report', name: 'generate-report')]
    public function generateReport(PaymentsService $paymentsService): Response
    {
        $reportDate = new \DateTimeImmutable((new  \DateTimeImmutable())->format('Y-m-01'));
        $paymentsService->generatePaymentList($reportDate);

        return $this->json([
            'message' => 'Generating report in progress',
            'code' => 200,
        ]);
    }
}
