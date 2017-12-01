<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\SalesOrder;
use AppBundle\Form\Admin\SalesOrderType;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/admin/sales_order")
 */
class SalesOrderController extends Controller
{
    /**
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return Response
     *
     * @Route("/", name="admin_sales_order_index")
     * @Method("GET")
     */
    public function indexAction(Request $request, PaginatorInterface $paginator): Response
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery('SELECT o FROM AppBundle:SalesOrder o');

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
     * @Route("/new", name="admin_sales_order_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request): Response
    {
        $order = new SalesOrder();

        $form = $this->createForm(SalesOrderType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($order);
            $em->flush();

            $this->addFlash('success', 'order.created_successfully');

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
     * @Route("/{id}/edit", requirements={"id": "\d+"}, name="admin_sales_order_edit")
     * @Method({"GET", "POST"})
     * @Security("is_granted('edit', order)")
     */
    public function editAction(Request $request, SalesOrder $order): Response
    {
        $form = $this->createForm(SalesOrderType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'order.updated_successfully');

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
     * @Route("/{id}/delete", name="admin_sales_order_delete")
     * @Method("POST")
     * @Security("is_granted('delete', order)")
     */
    public function deleteAction(Request $request, SalesOrder $order): Response
    {
        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('admin_sales_order_index');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($order);
        $em->flush();

        $this->addFlash('success', 'order.deleted_successfully');

        return $this->redirectToRoute('admin_sales_order_index');
    }
}
