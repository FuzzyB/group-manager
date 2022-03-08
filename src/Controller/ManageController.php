<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ManageController extends AbstractController
{
    public function groupsAction(): Response
    {
        $number = random_int(0, 100);

        return $this->render('manage/groups.html.twig', [
            'number' => $number,
        ]);
    }


}
