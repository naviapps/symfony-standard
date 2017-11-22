<?php

namespace CmsBundle\Controller\Admin;

use CmsBundle\Entity\Page;
use CmsBundle\Form\Admin\PageType;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/admin/cms/page")
 */
class PageController extends Controller
{
    /**
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return Response
     *
     * @Route("/", name="admin_cms_page_index")
     * @Method("GET")
     */
    public function indexAction(Request $request, PaginatorInterface $paginator): Response
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery('SELECT p FROM CmsBundle:Page p');

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            Page::NUM_ITEMS
        );

        return $this->render('admin/cms/page/index.html.twig', ['pagination' => $pagination]);
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @Route("/new", name="admin_cms_page_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request): Response
    {
        $page = new Page();

        $form = $this->createForm(PageType::class, $page)
            ->add('saveAndContinueEdit', SubmitType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($page);
            $em->flush();

            $this->addFlash('success', 'page.created_successfully');

            if ($form->get('saveAndContinueEdit')->isClicked()) {
                return $this->redirectToRoute('admin_cms_page_edit', ['id' => $page->getId()]);
            }

            return $this->redirectToRoute('admin_cms_page_index');
        }

        return $this->render('admin/cms/page/new.html.twig', [
            'page' => $page,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @param Page $page
     * @return Response
     *
     * @Route("/{id}/edit", requirements={"id": "\d+"}, name="admin_cms_page_edit")
     * @Method({"GET", "POST"})
     * @Security("is_granted('edit', page)")
     */
    public function editAction(Request $request, Page $page): Response
    {
        $form = $this->createForm(PageType::class, $page)
            ->add('saveAndContinueEdit', SubmitType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'page.updated_successfully');

            if ($form->get('saveAndContinueEdit')->isClicked()) {
                return $this->redirectToRoute('admin_cms_page_edit', ['id' => $page->getId()]);
            }

            return $this->redirectToRoute('admin_cms_page_index');
        }

        return $this->render('admin/cms/page/edit.html.twig', [
            'page' => $page,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @param Page $page
     * @return Response
     *
     * @Route("/{id}/delete", name="admin_cms_page_delete")
     * @Method("POST")
     * @Security("is_granted('delete', page)")
     */
    public function deleteAction(Request $request, Page $page): Response
    {
        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('admin_cms_page_index');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($page);
        $em->flush();

        $this->addFlash('success', 'page.deleted_successfully');

        return $this->redirectToRoute('admin_cms_page_index');
    }
}
