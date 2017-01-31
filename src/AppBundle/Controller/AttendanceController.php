<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
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
     * http://symfony.com/blog/new-in-symfony-3-2-user-value-resolver-for-controllers
     * http://stackoverflow.com/questions/9812510/symfony2-how-to-modify-the-current-users-entity-using-a-form
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

        return $this->redirectToRoute('app_security_logout');
    }

    /**
     * @Route("/do-non-attendance", name="app_attendance_doNonAttendance")
     */
    public function doNonAttendance()
    {
        return $this->redirectToRoute('app_security_logout');
    }
}
