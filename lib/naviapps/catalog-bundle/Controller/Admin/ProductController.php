<?php

namespace Naviapps\Bundle\CatalogBundle\Controller\Admin;

use Knp\Component\Pager\PaginatorInterface;
use Naviapps\Bundle\CatalogBundle\Entity\Product;
use Naviapps\Bundle\CatalogBundle\Repository\ProductRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/admin/catalog/product", name="naviapps_catalog_admin_product_")
 */
class ProductController extends AbstractController
{
    /** @var string */
    private $productClass;
    /** @var string */
    private $adminProductFormType;

    /**
     * @param string $productClass
     * @param string $adminProductFormType
     */
    public function __construct(string $productClass, string $adminProductFormType)
    {
        $this->productClass = $productClass;
        $this->adminProductFormType = $adminProductFormType;
    }

    /**
     * @param Request $request
     * @param ProductRepository $productRepository
     * @param PaginatorInterface $paginator
     * @return Response
     *
     * @Route("/", methods={"GET"}, name="index")
     */
    public function index(Request $request, ProductRepository $productRepository, PaginatorInterface $paginator): Response
    {
        $query = $productRepository->createQueryBuilder('p')->getQuery();

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            Product::NUM_ITEMS
        );

        return $this->render('@NaviappsCatalog/Admin/Product/index.html.twig', ['pagination' => $pagination]);
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @Route("/new", methods={"GET", "POST"}, name="new")
     */
    public function new(Request $request): Response
    {
        $product = new $this->productClass();

        $form = $this->createForm($this->adminProductFormType, $product);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

            $this->addFlash('success', 'product.created_successfully');

            return $this->redirectToRoute('naviapps_catalog_admin_product_index');
        }

        return $this->render('@NaviappsCatalog/Admin/Product/new.html.twig', [
            'product' => $product,
            'form'    => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @param Product $product
     * @return Response
     *
     * @Route("/{id}/edit", requirements={"id": "\d+"}, methods={"GET", "POST"}, name="edit")
     * @Security("is_granted('edit', product)")
     */
    public function edit(Request $request, Product $product): Response
    {
        $form = $this->createForm($this->adminProductFormType, $product);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'product.updated_successfully');

            return $this->redirectToRoute('naviapps_catalog_admin_product_index');
        }

        return $this->render('@NaviappsCatalog/Admin/Product/edit.html.twig', [
            'product' => $product,
            'form'    => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @param Product $product
     * @return Response
     *
     * @Route("/{id}/delete", methods={"POST"}, name="delete")
     * @Security("is_granted('delete', product)")
     */
    public function delete(Request $request, Product $product): Response
    {
        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('naviapps_catalog_admin_product_index');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($product);
        $em->flush();

        $this->addFlash('success', 'product.deleted_successfully');

        return $this->redirectToRoute('naviapps_catalog_admin_product_index');
    }
}
