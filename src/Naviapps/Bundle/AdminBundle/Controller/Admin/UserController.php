<?php

namespace Naviapps\Bundle\AdminBundle\Controller\Admin;

use Knp\Component\Pager\PaginatorInterface;
use Naviapps\Bundle\AdminBundle\Entity\User;
use Naviapps\Bundle\AdminBundle\Form\Admin\UserType;
use Naviapps\Bundle\AdminBundle\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/admin/admin/user", name="naviapps_admin_admin_user_")
 */
class UserController extends Controller
{
    /**
     * @param Request $request
     * @param UserRepository $userRepository
     * @param PaginatorInterface $paginator
     * @return Response
     *
     * @Route("/", name="index")
     * @Method("GET")
     */
    public function index(Request $request, UserRepository $userRepository, PaginatorInterface $paginator): Response
    {
        $query = $userRepository->createQueryBuilder('u')->getQuery();

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            User::NUM_ITEMS
        );

        return $this->render('@NaviappsAdmin/Admin/User/index.html.twig', ['pagination' => $pagination]);
    }

    /**
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return Response
     *
     * @Route("/new", name="new")
     * @Method({"GET", "POST"})
     */
    public function new(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new User();

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'user.created_successfully');

            return $this->redirectToRoute('naviapps_admin_admin_user_index');
        }

        return $this->render('@NaviappsAdmin/Admin/User/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @param User $user
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return Response
     *
     * @Route("/{id}/edit", requirements={"id": "\d+"}, name="edit")
     * @Method({"GET", "POST"})
     * @Security("is_granted('edit', user)")
     */
    public function edit(Request $request, User $user, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (0 < strlen($user->getPlainPassword())) {
                $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
                $user->setPassword($password);
            }
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'user.updated_successfully');

            return $this->redirectToRoute('naviapps_admin_admin_user_index');
        }

        return $this->render('@NaviappsAdmin/Admin/User/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @param User $user
     * @return Response
     *
     * @Route("/{id}/delete", name="delete")
     * @Method("POST")
     * @Security("is_granted('delete', user)")
     */
    public function delete(Request $request, User $user): Response
    {
        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('naviapps_admin_admin_user_index');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();

        $this->addFlash('success', 'user.deleted_successfully');

        return $this->redirectToRoute('naviapps_admin_admin_user_index');
    }
}
