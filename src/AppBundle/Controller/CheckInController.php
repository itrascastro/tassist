<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
            ]
        );
    }
}
