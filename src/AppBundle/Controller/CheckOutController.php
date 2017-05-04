<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CheckOutController extends Controller
{
    /**
     * @Route("/{id}", name="app_checkOut_index")
     * @Security("has_role('ROLE_USER')")
     */
    public function indexAction(User $user)
    {
        $checkOuts = $user->getCheckOuts();

        return $this->render(':records:records.html.twig',
            [
                'records'           => $checkOuts,
                'title'             => 'Sortides',
                'maxDelayAllowed'   => User::MAX_DELAY_ALLOWED,
                'user'              => $user,
            ]
        );
    }
}
