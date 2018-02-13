<?php

namespace Naviapps\Bundle\CustomerBundle\Controller\Admin;

use FOS\UserBundle\Model\UserManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Naviapps\Bundle\CustomerBundle\Entity\Customer;
use Naviapps\Bundle\CustomerBundle\Repository\CustomerRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/admin/customer", name="naviapps_customer_admin_customer_")
 */
class CustomerController extends Controller
{
    /** @var string */
    private $adminCustomerFormType;

    /**
     * @param string $adminCustomerFormType
     */
    public function __construct(string $adminCustomerFormType)
    {
        $this->adminCustomerFormType = $adminCustomerFormType;
    }

    /**
     * @param Request $request
     * @param CustomerRepository $customerRepository
     * @param PaginatorInterface $paginator
     * @return Response
     *
     * @Route("/", name="index")
     * @Method("GET")
     */
    public function index(Request $request, CustomerRepository $customerRepository, PaginatorInterface $paginator): Response
    {
        $query = $customerRepository->createQueryBuilder('c')->getQuery();

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            Customer::NUM_ITEMS
        );

        return $this->render('@NaviappsCustomer/Admin/Customer/index.html.twig', ['pagination' => $pagination]);
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

        $form = $this->createForm($this->adminCustomerFormType, $customer)
            ->add('saveAndContinueEdit', SubmitType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userManager->updateUser($customer);

            $this->addFlash('success', 'customer.created_successfully');

            if ($form->get('saveAndContinueEdit')->isClicked()) {
                return $this->redirectToRoute('naviapps_customer_admin_customer_edit', ['id' => $customer->getId()]);
            }

            return $this->redirectToRoute('naviapps_customer_admin_customer_index');
        }

        return $this->render('@NaviappsCustomer/Admin/Customer/new.html.twig', [
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
        $form = $this->createForm($this->adminCustomerFormType, $customer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var $userManager UserManagerInterface */
            $userManager = $this->get('fos_user.user_manager');
            $userManager->updateUser($customer);

            $this->addFlash('success', 'customer.updated_successfully');

            return $this->redirectToRoute('naviapps_customer_admin_customer_index');
        }

        return $this->render('@NaviappsCustomer/Admin/Customer/edit.html.twig', [
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
            return $this->redirectToRoute('naviapps_customer_admin_customer_index');
        }

        /** @var $userManager UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');
        $userManager->deleteUser($customer);

        $this->addFlash('success', 'customer.deleted_successfully');

        return $this->redirectToRoute('naviapps_customer_admin_customer_index');
    }
}
