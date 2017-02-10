<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    /**
     * @Route("/", name="app_admin_user_index")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $userRepo = $em->getRepository('AppBundle:User');

        $users = $userRepo->findAll();

        return $this->render(':admin/user:users.html.twig',
            [
                'users' => $users,
                'title' => 'Users',
            ]
        );
    }

    /**
     * @Route("/create", name="app_admin_user_create")
     */
    public function createAction()
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        return $this->render(':admin/user:form.html.twig',
            [
                'form'      => $form->createView(),
                'action'    => $this->generateUrl('app_admin_user_doCreate'),
                'title'     => 'New user',
            ]
        );
    }

    /**
     * @Route("/do-create", name="app_admin_user_doCreate")
     */
    public function doCreateAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isValid()) {
            if ($user->getIsAdmin()) {
                $user->setRoles(['ROLE_ADMIN']);
            }

            $em = $this->getDoctrine()->getManager();

            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('app_admin_user_create');
        }

        return $this->render(':admin/user:form.html.twig',
            [
                'form'      => $form->createView(),
                'action'    => $this->generateUrl('app_admin_user_doCreate'),
                'title'     => 'New user',
            ]
        );
    }

    /**
     * @Route("/edit/{id}", name="app_admin_user_edit")
     */
    public function editAction(User $user)
    {
        $user->setIsAdmin($user->hasRole('ROLE_ADMIN'));
        $form = $this->createForm(UserType::class, $user, ['update' => true, 'submitLabel' => 'Update user']);

        return $this->render(':admin/user:form.html.twig',
            [
                'form'      => $form->createView(),
                'action'    => $this->generateUrl('app_admin_user_doEdit', ['id' => $user->getId()]),
                'title'     => 'Edit user',
            ]
        );
    }

    /**
     * @Route("/do-edit/{id}", name="app_admin_user_doEdit")
     * @param Request $request
     * @Method({"POST"})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function doEditAction(Request $request, User $user)
    {
        $form = $this->createForm(UserType::class, $user, ['update' => true, 'submitLabel' => 'Update user']);

        $form->handleRequest($request);

        if ($form->isValid()) {
            if ($user->getIsAdmin()) {
                $user->setRoles(['ROLE_ADMIN']);
            } else {
                $user->setRoles(['ROLE_USER']);
            }

            $em = $this->getDoctrine()->getManager();

            // PlainPassword is not a field watched from Doctrine. So we have to trigger preUpdate manually
            $eventManager = $em->getEventManager();
            $eventArgs = new LifecycleEventArgs($user, $em);
            $eventManager->dispatchEvent(\Doctrine\ORM\Events::preUpdate, $eventArgs);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('app_admin_user_index');
        }

        return $this->render(':admin/user:form.html.twig',
            [
                'form'      => $form->createView(),
                'action'    => $this->generateUrl('app_admin_user_doEdit', ['id' => $user->getId()]),
                'title'     => 'Edit user',
            ]
        );
    }

    /**
     * @Route("/remove/{id}", name="app_admin_user_remove")
     */
    public function removeAction(User $user)
    {
        $em = $this->getDoctrine()->getManager();

        $em->remove($user);
        $em->flush();

        return $this->redirectToRoute('app_admin_user_index');
    }
}
