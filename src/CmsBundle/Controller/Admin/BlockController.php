<?php

namespace CmsBundle\Controller\Admin;

use CmsBundle\Entity\Block;
use CmsBundle\Form\Admin\BlockType;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/admin/cms/block")
 */
class BlockController extends Controller
{
    /**
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return Response
     *
     * @Route("/", name="admin_cms_block_index")
     * @Method("GET")
     */
    public function indexAction(Request $request, PaginatorInterface $paginator): Response
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery('SELECT p FROM CmsBundle:Block p');

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            Block::NUM_ITEMS
        );

        return $this->render('admin/cms/block/index.html.twig', ['pagination' => $pagination]);
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @Route("/new", name="admin_cms_block_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request): Response
    {
        $block = new Block();

        $form = $this->createForm(BlockType::class, $block)
            ->add('saveAndContinueEdit', SubmitType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($block);
            $em->flush();

            $this->addFlash('success', 'block.created_successfully');

            if ($form->get('saveAndContinueEdit')->isClicked()) {
                return $this->redirectToRoute('admin_cms_block_edit', ['id' => $block->getId()]);
            }

            return $this->redirectToRoute('admin_cms_block_index');
        }

        return $this->render('admin/cms/block/new.html.twig', [
            'block' => $block,
            'form'  => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @param Block $block
     * @return Response
     *
     * @Route("/{id}/edit", requirements={"id": "\d+"}, name="admin_cms_block_edit")
     * @Method({"GET", "POST"})
     * @Security("is_granted('edit', block)")
     */
    public function editAction(Request $request, Block $block): Response
    {
        $form = $this->createForm(BlockType::class, $block)
            ->add('saveAndContinueEdit', SubmitType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'block.updated_successfully');

            if ($form->get('saveAndContinueEdit')->isClicked()) {
                return $this->redirectToRoute('admin_cms_block_edit', ['id' => $block->getId()]);
            }

            return $this->redirectToRoute('admin_cms_block_index');
        }

        return $this->render('admin/cms/block/edit.html.twig', [
            'block' => $block,
            'form'  => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @param Block $block
     * @return Response
     *
     * @Route("/{id}/delete", name="admin_cms_block_delete")
     * @Method("POST")
     * @Security("is_granted('delete', block)")
     */
    public function deleteAction(Request $request, Block $block): Response
    {
        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('admin_cms_block_index');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($block);
        $em->flush();

        $this->addFlash('success', 'block.deleted_successfully');

        return $this->redirectToRoute('admin_cms_block_index');
    }
}
