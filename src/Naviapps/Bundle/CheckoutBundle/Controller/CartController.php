<?php

namespace Naviapps\Bundle\CheckoutBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/checkout/cart")
 */
class CartController extends Controller
{
    /**
     * @return Response
     *
     * @Route("/", name="naviapps_checkout_cart_index")
     */
    public function indexAction(): Response
    {
        return $this->render('@NaviappsCheckout/Cart/index.html.twig', []);
    }

    /**
     * @return Response
     *
     * @Route("/{id}/delete", name="naviapps_checkout_cart_delete")
     * @Method("POST")
     */
    public function deleteAction(): Response
    {
        return $this->redirectToRoute('naviapps_checkout_cart_index');
    }
}
