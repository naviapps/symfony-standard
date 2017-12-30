<?php

namespace Naviapps\Bundle\CatalogBundle\Controller\Admin;

use Naviapps\Bundle\CatalogBundle\Entity\Category;
use Naviapps\Bundle\CatalogBundle\Repository\CategoryRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/admin/catalog/category", name="naviapps_catalog_admin_category_")
 */
class CategoryController extends Controller
{
    /**
     * @param CategoryRepository $categoryRepository
     * @return Response
     *
     * @Route("/", name="index")
     * @Method("GET")
     */
    public function index(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();

        return $this->render('@NaviappsCatalog/Admin/Category/index.html.twig', ['categories' => $categories]);
    }

    /**
     * @param Request $request
     * @param CategoryRepository $categoryRepository
     * @param int $id
     * @return Response
     *
     * @Route("/{id}/delete", name="delete")
     * @Method("POST")
     */
    public function delete(Request $request, CategoryRepository $categoryRepository, int $id): Response
    {
        $category = $categoryRepository->find($id);
        if (!$category) {
            throw $this->createNotFoundException(sprintf('%s object not found.', $categoryRepository->getClassName()));
        }
        $this->denyAccessUnlessGranted('delete', $category);

        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('naviapps_catalog_admin_category_index');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($category);
        $em->flush();

        $this->addFlash('success', 'category.deleted_successfully');

        return $this->redirectToRoute('naviapps_catalog_admin_category_index');
    }
}
