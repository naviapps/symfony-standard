<?php

namespace App\Controller\Admin;

use App\Entity\CatalogProduct;
use App\Form\Admin\CatalogProductType;
use App\Repository\CatalogProductRepository;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/admin/catalog_product", name="admin_catalog_product_")
 */
class CatalogProductController extends Controller
{
    /**
     * @param Request $request
     * @param CatalogProductRepository $productRepository
     * @param PaginatorInterface $paginator
     * @return Response
     *
     * @Route("/", name="index")
     * @Method("GET")
     */
    public function index(Request $request, CatalogProductRepository $productRepository, PaginatorInterface $paginator): Response
    {
        $query = $productRepository->createQueryBuilder('p')->getQuery();

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            CatalogProduct::NUM_ITEMS
        );

        return $this->render('admin/catalog_product/index.html.twig', ['pagination' => $pagination]);
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
        $product = new CatalogProduct();

        $form = $this->createForm(CatalogProductType::class, $product);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

            $this->addFlash('success', 'catalog_product.created_successfully');

            return $this->redirectToRoute('admin_catalog_product_index');
        }

        return $this->render('admin/catalog_product/new.html.twig', [
            'product' => $product,
            'form'    => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @param CatalogProduct $product
     * @return Response
     *
     * @Route("/{id}/edit", requirements={"id": "\d+"}, name="edit")
     * @Method({"GET", "POST"})
     * @Security("is_granted('edit', product)")
     */
    public function edit(Request $request, CatalogProduct $product): Response
    {
        $form = $this->createForm(CatalogProductType::class, $product);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'catalog_product.updated_successfully');

            return $this->redirectToRoute('admin_catalog_product_index');
        }

        return $this->render('admin/catalog_product/edit.html.twig', [
            'product' => $product,
            'form'    => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @param CatalogProduct $product
     * @return Response
     *
     * @Route("/{id}/delete", name="delete")
     * @Method("POST")
     * @Security("is_granted('delete', product)")
     */
    public function delete(Request $request, CatalogProduct $product): Response
    {
        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('admin_catalog_product_index');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($product);
        $em->flush();

        $this->addFlash('success', 'catalog_product.deleted_successfully');

        return $this->redirectToRoute('admin_catalog_product_index');
    }
}
