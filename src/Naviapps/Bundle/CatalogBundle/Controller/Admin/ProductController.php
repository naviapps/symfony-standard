<?php

namespace Naviapps\Bundle\CatalogBundle\Controller\Admin;

use Knp\Component\Pager\PaginatorInterface;
use Naviapps\Bundle\CatalogBundle\Entity\Product;
use Naviapps\Bundle\CatalogBundle\Form\Admin\ProductType;
use Naviapps\Bundle\CatalogBundle\Repository\ProductRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/admin/catalog/product", name="naviapps_catalog_admin_product_")
 */
class ProductController extends Controller
{
    /**
     * @param Request $request
     * @param ProductRepository $productRepository
     * @param PaginatorInterface $paginator
     * @return Response
     *
     * @Route("/", name="index")
     * @Method("GET")
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
     * @param ProductRepository $productRepository
     * @return Response
     *
     * @Route("/new", name="new")
     * @Method({"GET", "POST"})
     */
    public function new(Request $request, ProductRepository $productRepository): Response
    {
        $product = $productRepository->build();

        $form = $this->createForm(ProductType::class, $product);
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
     * @param ProductRepository $productRepository
     * @param int $id
     * @return Response
     *
     * @Route("/{id}/edit", requirements={"id": "\d+"}, name="edit")
     * @Method({"GET", "POST"})
     */
    public function edit(Request $request, ProductRepository $productRepository, int $id): Response
    {
        $product = $productRepository->find($id);
        if (!$product) {
            throw $this->createNotFoundException(sprintf('%s object not found.', $productRepository->getClassName()));
        }
        $this->denyAccessUnlessGranted('edit', $product);

        $form = $this->createForm(ProductType::class, $product);
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
     * @param ProductRepository $productRepository
     * @param int $id
     * @return Response
     *
     * @Route("/{id}/delete", name="delete")
     * @Method("POST")
     */
    public function delete(Request $request, ProductRepository $productRepository, int $id): Response
    {
        $product = $productRepository->find($id);
        if (!$product) {
            throw $this->createNotFoundException(sprintf('%s object not found.', $productRepository->getClassName()));
        }
        $this->denyAccessUnlessGranted('delete', $product);

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
