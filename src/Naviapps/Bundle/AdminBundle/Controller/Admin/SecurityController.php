<?php

namespace Naviapps\Bundle\AdminBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * @Route("/admin", name="naviapps_admin_admin_security_")
 */
class SecurityController extends Controller
{
    /**
     * @param AuthenticationUtils $helper
     * @return Response
     *
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $helper): Response
    {
        return $this->render('@NaviappsAdmin/Admin/Security/login.html.twig', [
            'last_username' => $helper->getLastUsername(),
            'error'         => $helper->getLastAuthenticationError(),
        ]);
    }

    /**
     * @throws \Exception
     *
     * @Route("/logout", name="logout")
     */
    public function logout(): void
    {
        throw new \Exception('This should never be reached!');
    }
}
