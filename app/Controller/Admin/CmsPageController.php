<?php

namespace App\Controller\Admin;

use App\Entity\CmsPage;
use App\Form\Admin\CmsPageType;
use App\Repository\CmsPageRepository;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/admin/cms_page", name="admin_cms_page_")
 */
class CmsPageController extends Controller
{
    /**
     * @param Request $request
     * @param CmsPageRepository $pageRepository
     * @param PaginatorInterface $paginator
     * @return Response
     *
     * @Route("/", name="index")
     * @Method("GET")
     */
    public function index(Request $request, CmsPageRepository $pageRepository, PaginatorInterface $paginator): Response
    {
        $query = $pageRepository->createQueryBuilder('p')->getQuery();

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            CmsPage::NUM_ITEMS
        );

        return $this->render('admin/cms_page/index.html.twig', ['pagination' => $pagination]);
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
        $page = new CmsPage();

        $form = $this->createForm(CmsPageType::class, $page)
            ->add('saveAndContinueEdit', SubmitType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($page);
            $em->flush();

            $this->addFlash('success', 'cms_page.created_successfully');

            if ($form->get('saveAndContinueEdit')->isClicked()) {
                return $this->redirectToRoute('admin_cms_page_edit', ['id' => $page->getId()]);
            }

            return $this->redirectToRoute('admin_cms_page_index');
        }

        return $this->render('admin/cms_page/new.html.twig', [
            'page' => $page,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @param CmsPage $page
     * @return Response
     *
     * @Route("/{id}/edit", requirements={"id": "\d+"}, name="edit")
     * @Method({"GET", "POST"})
     * @Security("is_granted('edit', page)")
     */
    public function edit(Request $request, CmsPage $page): Response
    {
        $form = $this->createForm(CmsPageType::class, $page)
            ->add('saveAndContinueEdit', SubmitType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'cms_page.updated_successfully');

            if ($form->get('saveAndContinueEdit')->isClicked()) {
                return $this->redirectToRoute('admin_cms_page_edit', ['id' => $page->getId()]);
            }

            return $this->redirectToRoute('admin_cms_page_index');
        }

        return $this->render('admin/cms_page/edit.html.twig', [
            'page' => $page,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @param CmsPage $page
     * @return Response
     *
     * @Route("/{id}/delete", name="delete")
     * @Method("POST")
     * @Security("is_granted('delete', page)")
     */
    public function delete(Request $request, CmsPage $page): Response
    {
        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('admin_cms_page_index');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($page);
        $em->flush();

        $this->addFlash('success', 'cms_page.deleted_successfully');

        return $this->redirectToRoute('admin_cms_page_index');
    }
}
