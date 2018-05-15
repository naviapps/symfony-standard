<?php

namespace Naviapps\Bundle\CmsBundle\Controller\Admin;

use Knp\Component\Pager\PaginatorInterface;
use Naviapps\Bundle\CmsBundle\Entity\Block;
use Naviapps\Bundle\CmsBundle\Form\Admin\BlockType;
use Naviapps\Bundle\CmsBundle\Repository\BlockRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/admin/cms/block", name="naviapps_cms_admin_block_")
 */
class BlockController extends AbstractController
{
    /**
     * @param Request $request
     * @param BlockRepository $blockRepository
     * @param PaginatorInterface $paginator
     * @return Response
     *
     * @Route("/", methods={"GET"}, name="index")
     */
    public function index(Request $request, BlockRepository $blockRepository, PaginatorInterface $paginator): Response
    {
        $query = $blockRepository->createQueryBuilder('b')->getQuery();

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            Block::NUM_ITEMS
        );

        return $this->render('@NaviappsCms/Admin/Block/index.html.twig', ['pagination' => $pagination]);
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @Route("/new", methods={"GET", "POST"}, name="new")
     */
    public function new(Request $request): Response
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
                return $this->redirectToRoute('naviapps_cms_admin_block_edit', ['id' => $block->getId()]);
            }

            return $this->redirectToRoute('naviapps_cms_admin_block_index');
        }

        return $this->render('@NaviappsCms/Admin/Block/new.html.twig', [
            'block' => $block,
            'form'  => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @param Block $block
     * @return Response
     *
     * @Route("/{id}/edit", requirements={"id": "\d+"}, methods={"GET", "POST"}, name="edit")
     * @Security("is_granted('edit', block)")
     */
    public function edit(Request $request, Block $block): Response
    {
        $form = $this->createForm(BlockType::class, $block)
            ->add('saveAndContinueEdit', SubmitType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'block.updated_successfully');

            if ($form->get('saveAndContinueEdit')->isClicked()) {
                return $this->redirectToRoute('naviapps_cms_admin_block_edit', ['id' => $block->getId()]);
            }

            return $this->redirectToRoute('naviapps_cms_admin_block_index');
        }

        return $this->render('@NaviappsCms/Admin/Block/edit.html.twig', [
            'block' => $block,
            'form'  => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @param Block $block
     * @return Response
     *
     * @Route("/{id}/delete", methods={"POST"}, name="delete")
     * @Security("is_granted('delete', block)")
     */
    public function delete(Request $request, Block $block): Response
    {
        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('naviapps_cms_admin_block_index');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($block);
        $em->flush();

        $this->addFlash('success', 'block.deleted_successfully');

        return $this->redirectToRoute('naviapps_cms_admin_block_index');
    }
}
