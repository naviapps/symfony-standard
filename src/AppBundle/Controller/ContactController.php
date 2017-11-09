<?php

namespace AppBundle\Controller;

use AppBundle\Form\ContactFlow;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/contact")
 */
class ContactController extends Controller
{
    /**
     * @param ContactFlow $flow
     * @return Response
     *
     * @Route("/", name="contact_index")
     */
    public function indexAction(ContactFlow $flow): Response
    {
        $data = [];
        $flow->bind($data);

        // form of the current step
        /** @var $form FormInterface */
        $form = $flow->createForm();
        if ($form->isSubmitted() && $flow->isValid($form)) {
            $flow->saveCurrentStepData($form);

            if ($flow->nextStep()) {
                // form for the next step
                $form = $flow->createForm();
            } else {
                // flow finished
                $this->sendEmail($data);

                $flow->reset(); // remove step data from the session

                $this->addFlash('success', 'contact.sent_successfully');

                return $this->redirectToRoute('contact_index');
            }
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
            'flow' => $flow,
            'data' => $data,
        ]);
    }

    /**
     * @param array $data
     * @param null|\Swift_Mailer $mailer
     */
    private function sendEmail(array $data, ?\Swift_Mailer $mailer = null)
    {
        $emailSender = $this->getParameter('app.notifications.email_sender');

        $message = $mailer->createMessage()
            ->setSubject('')
            ->setFrom('')
            ->setTo($data['email'])
            ->setBcc($emailSender)
            ->setBody('')
        ;

        $mailer->send($message);
    }
}
