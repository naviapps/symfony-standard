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
    /** @var string */
    private $categoryClass;
    /** @var string */
    private $adminCategoryFormType;

    /**
     * @param string $categoryClass
     * @param string $adminCategoryFormType
     */
    public function __construct(string $categoryClass, string $adminCategoryFormType)
    {
        $this->categoryClass = $categoryClass;
        $this->adminCategoryFormType = $adminCategoryFormType;
    }

    /**
     * @param CategoryRepository $categoryRepository
     * @return Response
     *
     * @Route("/", name="index")
     * @Method("GET")
     */
    public function index(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->getRootNodes('position');

        return $this->render('@NaviappsCatalog/Admin/Category/index.html.twig', ['categories' => $categories]);
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
        $category = new $this->categoryClass();

        $form = $this->createForm($this->adminCategoryFormType, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            $this->addFlash('success', 'category.created_successfully');

            return $this->redirectToRoute('naviapps_catalog_admin_category_index');
        }

        return $this->render('@NaviappsCatalog/Admin/Category/new.html.twig', [
            'category' => $category,
            'form'     => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @param Category $category
     * @return Response
     *
     * @Route("/{id}/edit", requirements={"id": "\d+"}, name="edit")
     * @Method({"GET", "POST"})
     * @Security("is_granted('edit', category)")
     */
    public function edit(Request $request, Category $category): Response
    {
        $form = $this->createForm($this->adminCategoryFormType, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'category.updated_successfully');

            return $this->redirectToRoute('naviapps_catalog_admin_category_index');
        }

        return $this->render('@NaviappsCatalog/Admin/Category/edit.html.twig', [
            'category' => $category,
            'form'     => $form->createView(),
        ]);
    }

    /**
     * @param Category $category
     * @return Response
     *
     * @Route("/{id}/up", name="up")
     * @Method("GET")
     * @Security("is_granted('edit', category)")
     */
    public function up(Category $category): Response
    {
        $category->setPosition($category->getPosition() - 1);

        $this->getDoctrine()->getManager()->flush();

        $this->addFlash('success', 'category.updated_successfully');

        return $this->redirectToRoute('naviapps_catalog_admin_category_index');
    }

    /**
     * @param Category $category
     * @return Response
     *
     * @Route("/{id}/down", name="down")
     * @Security("is_granted('edit', category)")
     */
    public function down(Category $category): Response
    {
        $category->setPosition($category->getPosition() + 1);

        $this->getDoctrine()->getManager()->flush();

        $this->addFlash('success', 'category.updated_successfully');

        return $this->redirectToRoute('naviapps_catalog_admin_category_index');
    }

    /**
     * @param Request $request
     * @param Category $category
     * @return Response
     *
     * @Route("/{id}/delete", name="delete")
     * @Method("POST")
     * @Security("is_granted('delete', category)")
     */
    public function delete(Request $request, Category $category): Response
    {
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
