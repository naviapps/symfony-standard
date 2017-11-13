<?php

namespace AppBundle\EventListener;

use AppBundle\Entity\Page;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\TwigBundle\TwigEngine;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ExceptionListener
{
    /** @var EntityManagerInterface */
    private $entityManager;
    /** @var TwigEngine */
    private $templating;

    /**
     * @param EntityManagerInterface $em
     * @param TwigEngine $templating
     */
    public function __construct(EntityManagerInterface $em, TwigEngine $templating)
    {
        $this->entityManager = $em;
        $this->templating = $templating;
    }

    /**
     * @param GetResponseForExceptionEvent $event
     */
    public function onKernelException(GetResponseForExceptionEvent $event): void
    {
        $exception = $event->getException();

        if ($exception instanceof HttpExceptionInterface && $exception->getStatusCode() === 404) {
            $request = $event->getRequest();

            $page = $this->entityManager->getRepository(Page::class)
                ->findOneBy(['identifier' => substr($request->getPathInfo(), 1)]);
            if ($page) {
                $response = $this->templating->renderResponse('exception/page.html.twig', [
                    'page' => $page,
                ]);

                $event->setResponse($response);
            }
        }
    }
}
