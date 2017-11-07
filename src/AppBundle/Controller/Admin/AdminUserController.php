<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\AdminUser;
use AppBundle\Form\Admin\AdminUserType;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/admin/admin_user")
 */
class AdminUserController extends Controller
{
    /**
     * @param Request $request
     * @return Response
     *
     * @Route("/", name="admin_admin_user_index")
     * @Method("GET")
     */
    public function indexAction(Request $request, PaginatorInterface $paginator): Response
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery('SELECT au FROM AppBundle:AdminUser au');

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            AdminUser::NUM_ITEMS
        );

        return $this->render('admin/admin_user/index.html.twig', ['pagination' => $pagination]);
    }

    /**
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return Response
     *
     * @Route("/new", name="admin_admin_user_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $adminUser = new AdminUser();

        $form = $this->createForm(AdminUserType::class, $adminUser)
            ->add('saveAndCreateNew', SubmitType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $passwordEncoder->encodePassword($adminUser, $adminUser->getPlainPassword());
            $adminUser->setPassword($password);

            $em = $this->getDoctrine()->getManager();
            $em->persist($adminUser);
            $em->flush();

            $this->addFlash('success', 'admin_user.created_successfully');

            if ($form->get('saveAndCreateNew')->isClicked()) {
                return $this->redirectToRoute('admin_admin_user_new');
            }

            return $this->redirectToRoute('admin_admin_user_index');
        }

        return $this->render('admin/admin_user/new.html.twig', [
            'admin_user' => $adminUser,
            'form'       => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @param AdminUser $adminUser
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return Response
     *
     * @Route("/{id}/edit", requirements={"id": "\d+"}, name="admin_admin_user_edit")
     * @Method({"GET", "POST"})
     * @Security("is_granted('edit', adminUser)")
     */
    public function editAction(Request $request, AdminUser $adminUser, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $form = $this->createForm(AdminUserType::class, $adminUser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (0 < strlen($adminUser->getPlainPassword())) {
                $password = $passwordEncoder->encodePassword($adminUser, $adminUser->getPlainPassword());
                $adminUser->setPassword($password);
            }
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'admin_user.updated_successfully');

            return $this->redirectToRoute('admin_admin_user_edit', ['id' => $adminUser->getId()]);
        }

        return $this->render('admin/admin_user/edit.html.twig', [
            'admin_user' => $adminUser,
            'form'       => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @param AdminUser $adminUser
     * @return Response
     *
     * @Route("/{id}/delete", name="admin_admin_user_delete")
     * @Method("POST")
     * @Security("is_granted('delete', adminUser)")
     */
    public function deleteAction(Request $request, AdminUser $adminUser): Response
    {
        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('admin_admin_user_index');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($adminUser);
        $em->flush();

        $this->addFlash('success', 'admin_user.deleted_successfully');

        return $this->redirectToRoute('admin_admin_user_index');
    }
}
