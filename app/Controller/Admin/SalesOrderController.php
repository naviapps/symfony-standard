<?php

namespace App\Controller\Admin;

use App\Entity\SalesOrder;
use App\Form\Admin\SalesOrderType;
use App\Repository\SalesOrderRepository;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/admin/sales_order", name="admin_sales_order_")
 */
class SalesOrderController extends Controller
{
    /**
     * @param Request $request
     * @param SalesOrderRepository $orderRepository
     * @param PaginatorInterface $paginator
     * @return Response
     *
     * @Route("/", name="index")
     * @Method("GET")
     */
    public function index(Request $request, SalesOrderRepository $orderRepository, PaginatorInterface $paginator): Response
    {
        $query = $orderRepository->createQueryBuilder('o')->getQuery();

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            SalesOrder::NUM_ITEMS
        );

        return $this->render('admin/sales_order/index.html.twig', ['pagination' => $pagination]);
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @Route("/new", name="new")
     * @Method({"GET", "POST"})
     */
    public function new(Request $request): Response
    {
        $order = new SalesOrder();

        $form = $this->createForm(SalesOrderType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($order);
            $em->flush();

            $this->addFlash('success', 'sales_order.created_successfully');

            return $this->redirectToRoute('admin_sales_order_index');
        }

        return $this->render('admin/sales_order/new.html.twig', [
            'order' => $order,
            'form'  => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @param SalesOrder $order
     * @return Response
     *
     * @Route("/{id}/edit", requirements={"id": "\d+"}, name="edit")
     * @Method({"GET", "POST"})
     * @Security("is_granted('edit', order)")
     */
    public function edit(Request $request, SalesOrder $order): Response
    {
        $form = $this->createForm(SalesOrderType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'sales_order.updated_successfully');

            return $this->redirectToRoute('admin_sales_order_index');
        }

        return $this->render('admin/sales_order/edit.html.twig', [
            'order' => $order,
            'form'  => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @param SalesOrder $order
     * @return Response
     *
     * @Route("/{id}/delete", name="delete")
     * @Method("POST")
     * @Security("is_granted('delete', order)")
     */
    public function delete(Request $request, SalesOrder $order): Response
    {
        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('admin_sales_order_index');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($order);
        $em->flush();

        $this->addFlash('success', 'sales_order.deleted_successfully');

        return $this->redirectToRoute('admin_sales_order_index');
    }
}
