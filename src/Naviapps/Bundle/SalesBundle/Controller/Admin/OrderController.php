<?php

namespace Naviapps\Bundle\SalesBundle\Controller\Admin;

use Knp\Component\Pager\PaginatorInterface;
use Naviapps\Bundle\SalesBundle\Entity\Order;
use Naviapps\Bundle\SalesBundle\Form\Admin\OrderType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/admin/sales/order")
 */
class OrderController extends Controller
{
    /**
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return Response
     *
     * @Route("/", name="naviapps_sales_admin_order_index")
     * @Method("GET")
     */
    public function indexAction(Request $request, PaginatorInterface $paginator): Response
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery('SELECT o FROM NaviappsSalesBundle:Order o');

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            Order::NUM_ITEMS
        );

        return $this->render('@NaviappsSales/Admin/Order/index.html.twig', ['pagination' => $pagination]);
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @Route("/new", name="naviapps_sales_admin_order_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request): Response
    {
        $order = new Order();

        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($order);
            $em->flush();

            $this->addFlash('success', 'order.created_successfully');

            return $this->redirectToRoute('naviapps_sales_admin_order_index');
        }

        return $this->render('@NaviappsSales/Admin/Order/new.html.twig', [
            'order' => $order,
            'form'  => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @param Order $order
     * @return Response
     *
     * @Route("/{id}/edit", requirements={"id": "\d+"}, name="naviapps_sales_admin_order_edit")
     * @Method({"GET", "POST"})
     * @Security("is_granted('edit', order)")
     */
    public function editAction(Request $request, Order $order): Response
    {
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'order.updated_successfully');

            return $this->redirectToRoute('naviapps_sales_admin_order_index');
        }

        return $this->render('@NaviappsSales/Admin/Order/edit.html.twig', [
            'order' => $order,
            'form'  => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @param Order $order
     * @return Response
     *
     * @Route("/{id}/delete", name="naviapps_sales_admin_order_delete")
     * @Method("POST")
     * @Security("is_granted('delete', order)")
     */
    public function deleteAction(Request $request, Order $order): Response
    {
        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('naviapps_sales_admin_order_index');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($order);
        $em->flush();

        $this->addFlash('success', 'order.deleted_successfully');

        return $this->redirectToRoute('naviapps_sales_admin_order_index');
    }
}
