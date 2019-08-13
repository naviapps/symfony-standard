<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/checkout/cart", name="checkout_cart_")
 */
class CheckoutCartController extends AbstractController
{
    /**
     * @return Response
     *
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        return $this->render('checkout_cart/index.html.twig');
    }

    /**
     * @return Response
     *
     * @Route("/{id}/delete", name="delete")
     * @Method("POST")
     */
    public function delete(): Response
    {
        return $this->redirectToRoute('checkout_cart_index');
    }
}
