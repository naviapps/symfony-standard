<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/checkout")
 */
class CheckoutController extends Controller
{
    /**
     * @return Response
     *
     * @Route("/", name="checkout_index")
     */
    public function indexAction(): Response
    {
        return $this->render('checkout/index.html.twig');
    }
}
