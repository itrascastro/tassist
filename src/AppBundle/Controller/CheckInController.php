<?php

namespace AppBundle\Controller;

use AppBundle\Entity\CheckIn;
use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;

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

        $totalDelay = 0;

        $rows = array();
        $data = array('Data', 'Dia', 'Horari', 'Registre', 'Retard', 'Justificat', 'Comentari', 'Comentari Admin');
        $rows[] = implode(',', $data);

        /**
         * @var $checkIn CheckIn
         */
        foreach ($checkIns as $checkIn) {
            $totalDelay += $checkIn->getDelay();
            $data = array(
                $checkIn->getCreatedAt()->format('d/m/Y'),
                $checkIn->getDayOfWeek(),
                $checkIn->getScheduleTime()->format('H:i'),
                $checkIn->getCreatedAt()->format('H:i'),
                $checkIn->getDelay(),
                $checkIn->getJustified(),
                $checkIn->getCommentByUser(),
                $checkIn->getCommentByAdmin()
            );
            $rows[] = implode(',', $data);
        }

        $data = array('Total', $totalDelay);
        $rows[] = implode(',', $data);

        $content = implode("\n", $rows);

        $response = new Response($content);
        $response->headers->set('Content-Type', 'text/csv');

        return $response;

        /*
        return $this->render(':records:records.html.twig',
            [
                'records'           => $checkIns,
                'title'             => 'Entrades',
                'maxDelayAllowed'   => User::MAX_DELAY_ALLOWED,
                'user'              => $user,
            ]
        );
        */
    }
}
