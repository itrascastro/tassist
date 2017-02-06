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
            $delay          = 0;

            if ($form->get('entradaBtn')->isClicked()) {
                $this->doAttendanceIn($timeService, $day, $delay, $user, $attendance, $em);
            }
            if ($form->get('sortidaBtn')->isClicked()) {
                $this->doAttendanceOut($timeService, $day, $delay, $user, $attendance, $em);
            }
            if ($form->get('absenciaBtn')->isClicked()) {
                $this->doAttendanceAbsence($user, $attendance, $em);
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

    public function doAttendanceIn(TimeService $timeService, $day, $delay, User $user, Attendance $attendance, ObjectManager $em)
    {
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

        $checkIn = new CheckIn();
        $checkIn
            ->setDelay($delay)
            ->setJustified(0)
            ->setUser($user)
            ->setCommentByUser($attendance->getCommentByUser())
        ;

        $em->persist($checkIn);
    }

    public function doAttendanceOut(TimeService $timeService, $day, $delay, User $user, Attendance $attendance, ObjectManager $em)
    {
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

        $checkOut = new CheckOut();
        $checkOut
            ->setDelay($delay)
            ->setJustified(0)
            ->setUser($user)
            ->setCommentByUser($attendance->getCommentByUser())
        ;

        $em->persist($checkOut);
    }

    public function doAttendanceAbsence(User $user, Attendance $attendance, ObjectManager $em)
    {
        $absence = new Absence();
        $absence
            ->setJustified(1)
            ->setUser($user)
            ->setCommentByUser($attendance->getCommentByUser())
        ;

        $em->persist($absence);
    }
}
