<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Absence;
use AppBundle\Entity\Attendance;
use AppBundle\Entity\CheckIn;
use AppBundle\Entity\CheckOut;
use AppBundle\Entity\User;
use AppBundle\Form\AttendanceType;
use AppBundle\Service\TimeService;
use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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
     * @Route("/do-attendance", name="app_attendance_doAttendance")
     *
     * @Security("has_role('ROLE_USER')")
     * @Method(methods={"POST"})
     */
    public function doAttendanceAction(Request $request)
    {
        $attendance = new Attendance();
        $form = $this->createForm(AttendanceType::class, $attendance);
        $form
            ->remove('justified')
            ->remove('commentByAdmin')
        ;

        $form->handleRequest($request);

        if ($form->isValid()) {
            $timeService    = $this->get('app.service.timeService');
            $day            = (int) (new \DateTime())->format('w');
            $user           = $this->getUser();
            $em             = $this->getDoctrine()->getManager();
            $dayOfWeek      = $timeService->dayOfWeek($day);

            if ($form->get('entradaBtn')->isClicked()) {
                $this->doAttendanceIn($timeService, $day, $dayOfWeek, $user, $attendance, $em);
            }
            if ($form->get('sortidaBtn')->isClicked()) {
                $this->doAttendanceOut($timeService, $day, $dayOfWeek, $user, $attendance, $em);
            }
            if ($form->get('absenciaBtn')->isClicked()) {
                $this->doAttendanceAbsence($day, $dayOfWeek, $user, $attendance, $em);
            }

            $em->flush();

            return $this->redirectToRoute('app_security_logout');
        }

        return $this->render(':attendance:attendance.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }

    public function doAttendanceIn(TimeService $timeService, $day, $dayOfWeek, User $user, Attendance $attendance, ObjectManager $em)
    {
        $scheduleTime   = null;

        switch ($day) {
            case 1:
                $scheduleTime = $user->getMondayIn();
                break;
            case 2:
                $scheduleTime = $user->getTuesdayIn();
                break;
            case 3:
                $scheduleTime = $user->getWednesdayIn();
                break;
            case 4:
                $scheduleTime = $user->getThursdayIn();
                break;
            case 5:
                $scheduleTime = $user->getFridayIn();
                break;
        }

        $delay = $timeService->timeDiff($scheduleTime);

        $checkIn = new CheckIn();
        $checkIn
            ->setDelay($delay)
            ->setJustified(0)
            ->setUser($user)
            ->setDayOfWeek($dayOfWeek)
            ->setScheduleTime($scheduleTime)
            ->setCommentByUser($attendance->getCommentByUser())
        ;

        $em->persist($checkIn);
    }

    public function doAttendanceOut(TimeService $timeService, $day, $dayOfWeek, User $user, Attendance $attendance, ObjectManager $em)
    {
        $scheduleTime   = null;

        switch ($day) {
            case 1:
                $scheduleTime = $user->getMondayOut();
                break;
            case 2:
                $scheduleTime = $user->getTuesdayOut();
                break;
            case 3:
                $scheduleTime = $user->getWednesdayOut();
                break;
            case 4:
                $scheduleTime = $user->getThursdayOut();
                break;
            case 5:
                $scheduleTime = $user->getFridayOut();
                break;
        }

        $delay = -1 * $timeService->timeDiff($scheduleTime);

        $checkOut = new CheckOut();
        $checkOut
            ->setDelay($delay)
            ->setJustified(0)
            ->setUser($user)
            ->setDayOfWeek($dayOfWeek)
            ->setScheduleTime($scheduleTime)
            ->setCommentByUser($attendance->getCommentByUser())
        ;

        $em->persist($checkOut);
    }

    public function doAttendanceAbsence($day, $dayOfWeek, User $user, Attendance $attendance, ObjectManager $em)
    {
        $scheduleTime   = null;

        switch ($day) {
            case 1:
                $scheduleTime = $user->getMondayIn();
                break;
            case 2:
                $scheduleTime = $user->getTuesdayIn();
                break;
            case 3:
                $scheduleTime = $user->getWednesdayIn();
                break;
            case 4:
                $scheduleTime = $user->getThursdayIn();
                break;
            case 5:
                $scheduleTime = $user->getFridayIn();
                break;
        }

        $absence = new Absence();
        $absence
            ->setJustified(1)
            ->setUser($user)
            ->setDayOfWeek($dayOfWeek)
            ->setScheduleTime($scheduleTime)
            ->setCommentByUser($attendance->getCommentByUser())
        ;

        $em->persist($absence);
    }
}
