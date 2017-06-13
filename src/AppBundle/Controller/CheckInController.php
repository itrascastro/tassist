<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;

class CheckInController extends Controller
{
    /**
     * @Route("/{id}", name="app_checkIn_index")
     * @Security("has_role('ROLE_USER')")
     */
    public function indexAction(User $user)
    {
        $checkIns = $user->getCheckIns();

        return $this->render(':records:records.html.twig',
            [
                'records'           => $checkIns,
                'title'             => 'Entrades',
                'maxDelayAllowed'   => User::MAX_DELAY_ALLOWED,
                'user'              => $user,
            ]
        );
    }

    /**
     * @Route("/admin/users/date/{id}", name="app_checkInByUserDate_index")
     * @Security("has_role('ROLE_USER')")
     */
    public function checkInByUserDateAction(User $user)
    {
        $m = $this->getDoctrine()->getManager();
        $chekinRepo = $m->getRepository('AppBundle:CheckIn');

        $date1 = new \DateTime();
        $date1 = $date1->createFromFormat('d/m/Y', '01/03/2017');

        $date2 = new \DateTime();
        $date2 = $date2->createFromFormat('d/m/Y', '30/03/2017');

        $checkIns = $chekinRepo->getCheckInByUserDate($date1, $date2, 3);

        $totalRetard = 0;

        foreach ($checkIns as $checkIn) {
            $totalRetard += $checkIn->getDelay();
        }

        //echo $totalRetard;

        return $this->render(':records:records.html.twig',
            [
                'records'           => $checkIns,
                'title'             => 'Entrades',
                'maxDelayAllowed'   => User::MAX_DELAY_ALLOWED,
                'user'              => $user,
            ]
        );

    }
}
