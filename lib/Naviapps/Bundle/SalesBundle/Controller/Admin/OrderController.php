<?php

namespace Naviapps\Bundle\SalesBundle\Controller\Admin;

use Knp\Component\Pager\PaginatorInterface;
use Naviapps\Bundle\SalesBundle\Entity\Order;
use Naviapps\Bundle\SalesBundle\Form\Admin\OrderType;
use Naviapps\Bundle\SalesBundle\Repository\OrderRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/admin/sales/order", name="naviapps_sales_admin_order_")
 */
class OrderController extends Controller
{
    /**
     * @param Request $request
     * @param OrderRepository $orderRepository
     * @param PaginatorInterface $paginator
     * @return Response
     *
     * @Route("/", methods={"GET"}, name="index")
     */
    public function index(Request $request, OrderRepository $orderRepository, PaginatorInterface $paginator): Response
    {
        $query = $orderRepository->createQueryBuilder('o')->getQuery();

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            Order::NUM_ITEMS
        );

        return $this->render('@NaviappsSales/Admin/Order/index.html.twig', ['pagination' => $pagination]);
    }

    /**
     * @param Request $request
     * @param OrderRepository $orderRepository
     * @return Response
     *
     * @Route("/new", methods={"GET", "POST"}, name="new")
     */
    public function new(Request $request, OrderRepository $orderRepository): Response
    {
        $order = $orderRepository->build();

        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($order);
            $em->flush();

            $this->addFlash('success', 'sales_order.created_successfully');

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
     * @Route("/{id}/edit", requirements={"id": "\d+"}, methods={"GET", "POST"}, name="edit")
     * @Security("is_granted('edit', order)")
     */
    public function edit(Request $request, Order $order): Response
    {
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'sales_order.updated_successfully');

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
     * @Route("/{id}/delete", methods={"POST"}, name="delete")
     * @Security("is_granted('delete', order)")
     */
    public function delete(Request $request, Order $order): Response
    {
        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('naviapps_sales_admin_order_index');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($order);
        $em->flush();

        $this->addFlash('success', 'sales_order.deleted_successfully');

        return $this->redirectToRoute('naviapps_sales_admin_order_index');
    }
}
