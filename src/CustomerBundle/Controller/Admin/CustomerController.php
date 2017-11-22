<?php

namespace CustomerBundle\Controller\Admin;

use CustomerBundle\Entity\Customer;
use CustomerBundle\Form\Admin\CustomerType;
use FOS\UserBundle\Model\UserManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/admin/customer")
 */
class CustomerController extends Controller
{
    /**
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return Response
     *
     * @Route("/", name="admin_customer_index")
     * @Method("GET")
     */
    public function indexAction(Request $request, PaginatorInterface $paginator): Response
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery('SELECT c FROM CustomerBundle:Customer c');

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
     * @Route("/new", name="admin_customer_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request): Response
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
     * @Route("/{id}/edit", requirements={"id": "\d+"}, name="admin_customer_edit")
     * @Method({"GET", "POST"})
     * @Security("is_granted('edit', customer)")
     */
    public function editAction(Request $request, Customer $customer): Response
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
     * @Route("/{id}/delete", name="admin_customer_delete")
     * @Method("POST")
     * @Security("is_granted('delete', customer)")
     */
    public function deleteAction(Request $request, Customer $customer): Response
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
