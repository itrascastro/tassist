<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Absence;
use AppBundle\Entity\CheckIn;
use AppBundle\Entity\CheckOut;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AttendanceController extends Controller
{
    /**
     * @Route("/", name="app_attendance_index")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        if ($this->isGranted('ROLE_USER')) {
            return $this->render(':attendance:attendance.html.twig');
        }

        return $this->forward('AppBundle:Security:login');
    }

    /**
     * @Route("/do-attendance-in", name="app_attendance_doAttendanceIn")
     *
     */
    public function doAttendanceInAction()
    {
        $timeService = $this->get('app.service.timeService');

        $day = (int) (new \DateTime())->format('w');
        $delay = 0;

        switch ($day) {
            case 1:
                $delay = $timeService->timeDiff($this->getUser()->getMondayIn());
                break;
            case 2:
                $delay = $timeService->timeDiff($this->getUser()->getTuesdayIn());
                break;
            case 3:
                $delay = $timeService->timeDiff($this->getUser()->getWednesdayIn());
                break;
            case 4:
                $delay = $timeService->timeDiff($this->getUser()->getThursdayIn());
                break;
            case 5:
                $delay = $timeService->timeDiff($this->getUser()->getFridayIn());
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
     * @Route("/do-attendance-out", name="app_attendance_doAttendanceOut")
     */
    public function doAttendanceOutAction()
    {
        $timeService = $this->get('app.service.timeService');

        $day = (int) (new \DateTime())->format('w');
        $delay = 0;

        switch ($day) {
            case 1:
                $delay = $timeService->timeDiff($this->getUser()->getMondayOut());
                break;
            case 2:
                $delay = $timeService->timeDiff($this->getUser()->getTuesdayOut());
                break;
            case 3:
                $delay = $timeService->timeDiff($this->getUser()->getWednesdayOut());
                break;
            case 4:
                $delay = $timeService->timeDiff($this->getUser()->getThursdayOut());
                break;
            case 5:
                $delay = $timeService->timeDiff($this->getUser()->getFridayOut());
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
     * @Route("/do-non-attendance", name="app_attendance_doNonAttendance")
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
