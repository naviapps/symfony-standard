<?php

namespace App\Controller\Admin;

use App\Entity\CatalogCategory;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/admin/catalog_category", name="admin_catalog_category_")
 */
class CatalogCategoryController extends Controller
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
        $categories = $this->getDoctrine()->getRepository(CatalogCategory::class)->findAll();

        return $this->render('admin/catalog_category/index.html.twig', ['categories' => $categories]);
    }

    /**
     * @param Request $request
     * @param CatalogCategory $category
     * @return Response
     *
     * @Route("/{id}/delete", name="delete")
     * @Method("POST")
     * @Security("is_granted('delete', category)")
     */
    public function delete(Request $request, CatalogCategory $category): Response
    {
        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('admin_catalog_category_index');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($category);
        $em->flush();

        $this->addFlash('success', 'catalog_category.deleted_successfully');

        return $this->redirectToRoute('admin_catalog_category_index');
    }
}
