<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/checkout", name="checkout_")
 */
class CheckoutController extends AbstractController
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
