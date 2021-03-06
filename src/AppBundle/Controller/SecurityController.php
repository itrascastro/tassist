<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SecurityController extends Controller
{
    /**
     * @Route(
     *     path="/login",
     *     name="app_security_login"
     * )
     */
    public function loginAction()
    {
        if ($this->isGranted('ROLE_USER')) {
            return $this->render(':attendance:attendance.html.twig');
        }

        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render(
            'security/login.html.twig',
            array(
                // last username entered by the user
                'last_username' => $lastUsername,
                'error'         => $error,
            )
        );
    }

    /**
     * @Route(
     *     path="/login_check",
     *     name="app_security_check"
     * )
     */
    public function loginCheckAction()
    {
    }

    /**
     * @Route(
     *     path="/logout",
     *     name="app_security_logout"
     * )
     */
    public function logoutAction()
    {

    }
}
