<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CheckInController extends Controller
{
    /**
     * @Route("/", name="app_checkIn_index")
     */
    public function indexAction()
    {
        $checkIns = $this->getUser()->getCheckIns();

        return $this->render(':records:records.html.twig',
            [
                'records'   => $checkIns,
                'title'     => 'Entrades',
            ]
        );
    }
}
