<?php

namespace Naviapps\Bundle\CheckoutBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/checkout")
 */
class DefaultController extends Controller
{
    /**
     * @return Response
     *
     * @Route("/", name="naviapps_checkout_index")
     */
    public function indexAction(): Response
    {
        return $this->render('@NaviappsCheckout/Default/index.html.twig', []);
    }
}
