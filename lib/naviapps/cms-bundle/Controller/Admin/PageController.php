<?php

namespace Naviapps\Bundle\CmsBundle\Controller\Admin;

use Knp\Component\Pager\PaginatorInterface;
use Naviapps\Bundle\CmsBundle\Entity\Page;
use Naviapps\Bundle\CmsBundle\Form\Admin\PageType;
use Naviapps\Bundle\CmsBundle\Repository\PageRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/admin/cms/page", name="naviapps_cms_admin_page_")
 */
class PageController extends AbstractController
{
    /**
     * @param Request $request
     * @param PageRepository $pageRepository
     * @param PaginatorInterface $paginator
     * @return Response
     *
     * @Route("/", methods={"GET"}, name="index")
     */
    public function index(Request $request, PageRepository $pageRepository, PaginatorInterface $paginator): Response
    {
        $query = $pageRepository->createQueryBuilder('p')->getQuery();

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            Page::NUM_ITEMS
        );

        return $this->render('@NaviappsCms/Admin/Page/index.html.twig', ['pagination' => $pagination]);
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @Route("/new", methods={"GET", "POST"}, name="new")
     */
    public function new(Request $request): Response
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
                return $this->redirectToRoute('naviapps_cms_admin_page_edit', ['id' => $page->getId()]);
            }

            return $this->redirectToRoute('naviapps_cms_admin_page_index');
        }

        return $this->render('@NaviappsCms/Admin/Page/new.html.twig', [
            'page' => $page,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @param Page $page
     * @return Response
     *
     * @Route("/{id}/edit", requirements={"id": "\d+"}, methods={"GET", "POST"}, name="edit")
     * @Security("is_granted('edit', page)")
     */
    public function edit(Request $request, Page $page): Response
    {
        $form = $this->createForm(PageType::class, $page)
            ->add('saveAndContinueEdit', SubmitType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'page.updated_successfully');

            if ($form->get('saveAndContinueEdit')->isClicked()) {
                return $this->redirectToRoute('naviapps_cms_admin_page_edit', ['id' => $page->getId()]);
            }

            return $this->redirectToRoute('naviapps_cms_admin_page_index');
        }

        return $this->render('@NaviappsCms/Admin/Page/edit.html.twig', [
            'page' => $page,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @param Page $page
     * @return Response
     *
     * @Route("/{id}/delete", methods={"POST"}, name="delete")
     * @Security("is_granted('delete', page)")
     */
    public function delete(Request $request, Page $page): Response
    {
        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('naviapps_cms_admin_page_index');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($page);
        $em->flush();

        $this->addFlash('success', 'page.deleted_successfully');

        return $this->redirectToRoute('naviapps_cms_admin_page_index');
    }
}
