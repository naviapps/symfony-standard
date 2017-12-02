<?php

namespace App\Controller\Admin;

use App\Entity\Customer;
use App\Form\Admin\CustomerType;
use FOS\UserBundle\Model\UserManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/admin/customer", name="admin_customer_")
 */
class CustomerController extends Controller
{
    /**
     * @param Request $request
     * @return Response
     *
     * @Route("/", name="index")
     * @Method("GET")
     */
    public function index(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery('SELECT c FROM App:Customer c');

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            Customer::NUM_ITEMS
        );

        return $this->render('admin/customer/index.html.twig', ['pagination' => $pagination]);
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
        /** @var $userManager UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');

        $customer = $userManager->createUser();
        $customer->setEnabled(true);

        $form = $this->createForm(CustomerType::class, $customer)
            ->add('saveAndContinueEdit', SubmitType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userManager->updateUser($customer);

            $this->addFlash('success', 'customer.created_successfully');

            if ($form->get('saveAndContinueEdit')->isClicked()) {
                return $this->redirectToRoute('admin_customer_edit', ['id' => $customer->getId()]);
            }

            return $this->redirectToRoute('admin_customer_index');
        }

        return $this->render('admin/customer/new.html.twig', [
            'customer' => $customer,
            'form'     => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @param Customer $customer
     * @return Response
     *
     * @Route("/{id}/edit", requirements={"id": "\d+"}, name="edit")
     * @Method({"GET", "POST"})
     * @Security("is_granted('edit', customer)")
     */
    public function edit(Request $request, Customer $customer): Response
    {
        $form = $this->createForm(CustomerType::class, $customer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var $userManager UserManagerInterface */
            $userManager = $this->get('fos_user.user_manager');
            $userManager->updateUser($customer);

            $this->addFlash('success', 'customer.updated_successfully');

            return $this->redirectToRoute('admin_customer_index');
        }

        return $this->render('admin/customer/edit.html.twig', [
            'customer' => $customer,
            'form'     => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @param Customer $customer
     * @return Response
     *
     * @Route("/{id}/delete", name="delete")
     * @Method("POST")
     * @Security("is_granted('delete', customer)")
     */
    public function delete(Request $request, Customer $customer): Response
    {
        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('admin_customer_index');
        }

        /** @var $userManager UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');
        $userManager->deleteUser($customer);

        $this->addFlash('success', 'customer.deleted_successfully');

        return $this->redirectToRoute('admin_customer_index');
    }
}
