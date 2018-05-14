<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/checkout", name="checkout_")
 */
class CheckoutController extends Controller
{
    /**
     * @return Response
     *
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        return $this->render('checkout/index.html.twig');
    }
}
