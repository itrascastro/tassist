<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AbsenceController extends Controller
{
    /**
     * @Route("/", name="app_absence_index")
     * @Security("has_role('ROLE_USER')")
     */
    public function indexAction()
    {
        $absences = $this->getUser()->getAbsences();

        return $this->render(':records:records.html.twig',
            [
                'records'           => $absences,
                'title'             => 'Absences',
                'maxDelayAllowed'   => 1000, //big number to avoid delay in view
            ]
        );
    }
}
