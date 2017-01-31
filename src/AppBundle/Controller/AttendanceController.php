<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
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
        $timeService = $this->get('app.service.timeService');

        $now = new \DateTime();

        var_dump($now);die;

        echo $timeService->timeDiff($this->getUser()->getMondayIn());die;

        return $this->redirectToRoute('app_security_logout');
    }

    /**
     * @Route("/do-attendance-out", name="app_attendance_doAttendanceOut")
     */
    public function doAttendanceOutAction()
    {
        $em = $this->getDoctrine()->getManager();

        $admin = new User();
        $admin
            ->setUsername('itrascastro@email.com')
            ->setForename('Ismael')
            ->setSurname('Trascastro')
            ->setPlainPassword('1234')
            ->setRoles(['ROLE_ADMIN'])
            ->setMondayIn(new \DateTime('15:00'))
            ->setMondayOut(new \DateTime('21:00'))
        ;

        $em->persist($admin);
        $em->flush();


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
