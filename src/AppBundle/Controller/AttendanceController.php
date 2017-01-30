<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Validator\Constraints\DateTime;

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
     */
    public function doAttendanceInAction()
    {
        $mondayIn = date_format($this->getUser()->getMondayIn(), 'H:i');
        $now = date_format(new \DateTime(),'H:i');
        echo $now - $mondayIn;die;
        //$from_time = strtotime("2008-12-13 10:21:00");
        //echo round(abs($to_time - $from_time) / 60,2). " minute";
        return $this->redirectToRoute('app_security_logout');
    }

    /**
     * @Route("/do-attendance-out", name="app_attendance_doAttendanceOut")
     */
    public function doAttendanceOutAction()
    {
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
