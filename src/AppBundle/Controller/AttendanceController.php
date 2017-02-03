<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Absence;
use AppBundle\Entity\Attendance;
use AppBundle\Entity\CheckIn;
use AppBundle\Entity\CheckOut;
use AppBundle\Form\AttendanceType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AttendanceController extends Controller
{
    /**
     * @Route("/", name="app_attendance_index")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        if (!$this->isGranted('ROLE_USER')) {
            return $this->forward('AppBundle:Security:login');
        }

        $attendance = new Attendance();
        $form = $this->createForm(AttendanceType::class, $attendance);
        $form
            ->remove('justified')
            ->remove('commentByAdmin')
        ;

        return $this->render(':attendance:attendance.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }

    /**
     * @Route("/do-check-in", name="app_attendance_doCheckIn")
     *
     * @Security("has_role('ROLE_USER')")
     */
    public function doAttendanceInAction()
    {
        $timeService = $this->get('app.service.timeService');

        $day = (int) (new \DateTime())->format('w');
        $delay = 0;

        $user = $this->getUser();

        switch ($day) {
            case 1:
                $delay = $timeService->timeDiff($user->getMondayIn());
                break;
            case 2:
                $delay = $timeService->timeDiff($user->getTuesdayIn());
                break;
            case 3:
                $delay = $timeService->timeDiff($user->getWednesdayIn());
                break;
            case 4:
                $delay = $timeService->timeDiff($user->getThursdayIn());
                break;
            case 5:
                $delay = $timeService->timeDiff($user->getFridayIn());
                break;
        }

        $em = $this->getDoctrine()->getManager();

        $checkIn = new CheckIn();
        $checkIn
            ->setDelay($delay)
            ->setJustified(0)
            ->setUser($this->getUser())
        ;

        $em->persist($checkIn);
        $em->flush();

        return $this->redirectToRoute('app_security_logout');
    }

    /**
     * @Route("/do-check-out", name="app_attendance_doCheckOut")
     *
     * @Security("has_role('ROLE_USER')")
     */
    public function doAttendanceOutAction()
    {
        $timeService = $this->get('app.service.timeService');

        $day = (int) (new \DateTime())->format('w');
        $delay = 0;

        $user = $this->getUser();

        switch ($day) {
            case 1:
                $delay = $timeService->timeDiff($user->getMondayOut());
                break;
            case 2:
                $delay = $timeService->timeDiff($user->getTuesdayOut());
                break;
            case 3:
                $delay = $timeService->timeDiff($user->getWednesdayOut());
                break;
            case 4:
                $delay = $timeService->timeDiff($user->getThursdayOut());
                break;
            case 5:
                $delay = $timeService->timeDiff($user->getFridayOut());
                break;
        }

        $delay = -1 * $delay;

        $em = $this->getDoctrine()->getManager();

        $checkOut = new CheckOut();
        $checkOut
            ->setDelay($delay)
            ->setJustified(0)
            ->setUser($this->getUser())
        ;

        $em->persist($checkOut);
        $em->flush();

        return $this->redirectToRoute('app_security_logout');
    }

    /**
     * @Route("/do-absence", name="app_attendance_absence")
     *
     * @Security("has_role('ROLE_USER')")
     */
    public function doNonAttendance()
    {
        $em = $this->getDoctrine()->getManager();

        $absence = new Absence();
        $absence
            ->setJustified(1)
            ->setUser($this->getUser())
        ;

        $em->persist($absence);
        $em->flush();

        return $this->redirectToRoute('app_security_logout');
    }
}
