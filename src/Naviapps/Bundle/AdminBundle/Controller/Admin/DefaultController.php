<?php

namespace Naviapps\Bundle\AdminBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/admin", name="naviapps_admin_admin_")
 */
class DefaultController extends Controller
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        return $this->render('@NaviappsAdmin/Admin/Default/index.html.twig');
    }
}
