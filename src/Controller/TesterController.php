<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;


class TesterController extends AbstractController
{
    public function createAction(): Response
    {
        //@todo call the command for report generation or make link a service and prepare report

    }

}
