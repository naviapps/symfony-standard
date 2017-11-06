<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\User;
use AppBundle\Form\Admin\UserType;
use FOS\UserBundle\Model\UserManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/admin/user")
 */
class UserController extends Controller
{
    /**
     * @return Response
     *
     * @Route("/", name="admin_user_index")
     * @Method("GET")
     */
    public function indexAction(): Response
    {
        /** @var $userManager UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');
        $users = $userManager->findUsers();

        return $this->render('admin/user/index.html.twig', ['users' => $users]);
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @Route("/new", name="admin_user_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request): Response
    {
        /** @var $userManager UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');

        $user = $userManager->createUser();
        $user->setEnabled(true);

        $form = $this->createForm(UserType::class, $user)
            ->add('saveAndCreateNew', SubmitType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userManager->updateUser($user);

            $this->addFlash('success', 'user.created_successfully');

            if ($form->get('saveAndCreateNew')->isClicked()) {
                return $this->redirectToRoute('admin_user_new');
            }

            return $this->redirectToRoute('admin_user_index');
        }

        return $this->render('admin/user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @param User $user
     * @return Response
     *
     * @Route("/{id}/edit", requirements={"id": "\d+"}, name="admin_user_edit")
     * @Method({"GET", "POST"})
     * @Security("is_granted('edit', user)")
     */
    public function editAction(Request $request, User $user): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var $userManager UserManagerInterface */
            $userManager = $this->get('fos_user.user_manager');
            $userManager->updateUser($user);

            $this->addFlash('success', 'user.updated_successfully');

            return $this->redirectToRoute('admin_user_edit', ['id' => $user->getId()]);
        }

        return $this->render('admin/user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    /**
     * @param Request $request
     * @param User $user
     * @return Response
     *
     * @Route("/{id}/delete", name="admin_user_delete")
     * @Method("POST")
     * @Security("is_granted('delete', user)")
     */
    public function deleteAction(Request $request, User $user): Response
    {
        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('admin_user_index');
        }

        /** @var $userManager UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');
        $userManager->deleteUser($user);

        $this->addFlash('success', 'user.deleted_successfully');

        return $this->redirectToRoute('admin_user_index');
    }
}
