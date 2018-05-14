<?php

namespace Naviapps\Bundle\AdminBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/admin", name="naviapps_admin_")
 */
class DefaultController extends Controller
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        return $this->render('@NaviappsAdmin/Default/index.html.twig');
    }
}
