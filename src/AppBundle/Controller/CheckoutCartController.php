<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/checkout/cart")
 */
class CheckoutCartController extends Controller
{
    /**
     * @return Response
     *
     * @Route("/", name="checkout_cart_index")
     */
    public function indexAction(): Response
    {
        return $this->render('checkout_cart/index.html.twig');
    }

    /**
     * @return Response
     *
     * @Route("/{id}/delete", name="checkout_cart_delete")
     * @Method("POST")
     */
    public function deleteAction(): Response
    {
        return $this->redirectToRoute('checkout_cart_index');
    }
}
