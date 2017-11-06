<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * @Route("/admin")
 */
class SecurityController extends Controller
{
    /**
     * @param AuthenticationUtils $helper
     * @return Response
     *
     * @Route("/login", name="admin_security_login")
     */
    public function loginAction(AuthenticationUtils $helper): Response
    {
        return $this->render('admin/security/login.html.twig', [
            'last_username' => $helper->getLastUsername(),
            'error'         => $helper->getLastAuthenticationError(),
        ]);
    }

    /**
     * @throws \Exception
     *
     * @Route("/logout", name="admin_security_logout")
     */
    public function logoutAction(): void
    {
        throw new \Exception('This should never be reached!');
    }
}
