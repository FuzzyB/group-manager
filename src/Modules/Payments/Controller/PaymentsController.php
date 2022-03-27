<?php

namespace App\Modules\Payments\Controller;

use App\Modules\Payments\Application\PaymentsService;
use App\Modules\Payments\Infrastructure\Form\FilterCriteria;
use App\Modules\Payments\Infrastructure\Form\PaymentListCriteriaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PaymentsController extends AbstractController
{
    public function index(Request $request, PaymentsService $paymentsService): Response
    {
        $criteriaForm = new FilterCriteria();
        $criteriaForm->setAuDate((new \DateTime())->format('Y-m-01'));
        $criteriaForm->setFilterByColumn($request->query->get('filterColumn') ?? '');
        $criteriaForm->setFilterText(base64_decode($request->query->get('phrase'))  ?? '');
        $criteriaForm->setOrderType($request->query->get('sortType') ?? '');
        $criteriaForm->setSortByColumn($request->query->get('sortBy') ?? '');

        $form = $this->createForm(PaymentListCriteriaType::class, $criteriaForm);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var FilterCriteria $filterCriteria */
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
            $report = $paymentsService->getSalaryReport($criteriaForm);
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
