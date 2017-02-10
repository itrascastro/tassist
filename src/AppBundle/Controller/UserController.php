<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller
{
    /**
     * @Route("/", name="app_user_profile")
     * @Security("has_role('ROLE_USER')")
     */
    public function profileAction()
    {
        return $this->render(':user:profile.html.twig',
            [
                'user'      => $this->getUser(),
                'title'     => 'Profile',
            ]
        );
    }
}
