<?php

namespace App\Controller\Admin;

use App\Entity\CmsBlock;
use App\Form\Admin\CmsBlockType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/admin/cms_block", name="admin_cms_block_")
 */
class CmsBlockController extends Controller
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
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery('SELECT p FROM App:CmsBlock p');

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            CmsBlock::NUM_ITEMS
        );

        return $this->render('admin/cms_block/index.html.twig', ['pagination' => $pagination]);
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
        $block = new CmsBlock();

        $form = $this->createForm(CmsBlockType::class, $block)
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

        return $this->render('admin/cms_block/new.html.twig', [
            'block' => $block,
            'form'  => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @param CmsBlock $block
     * @return Response
     *
     * @Route("/{id}/edit", requirements={"id": "\d+"}, name="edit")
     * @Method({"GET", "POST"})
     * @Security("is_granted('edit', block)")
     */
    public function edit(Request $request, CmsBlock $block): Response
    {
        $form = $this->createForm(CmsBlockType::class, $block)
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

        return $this->render('admin/cms_block/edit.html.twig', [
            'block' => $block,
            'form'  => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @param CmsBlock $block
     * @return Response
     *
     * @Route("/{id}/delete", name="delete")
     * @Method("POST")
     * @Security("is_granted('delete', block)")
     */
    public function delete(Request $request, CmsBlock $block): Response
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
