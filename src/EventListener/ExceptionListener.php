<?php

namespace App\EventListener;

use App\Entity\CmsPage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class ExceptionListener
{
    /** @var EntityManagerInterface */
    private $entityManager;
    /** @var RequestStack */
    private $request;
    /** @var HttpKernelInterface */
    private $kernel;

    /**
     * @param EntityManagerInterface $em
     * @param $request
     * @param HttpKernelInterface $kernel
     */
    public function __construct(EntityManagerInterface $em, RequestStack $request, HttpKernelInterface $kernel)
    {
        $this->entityManager = $em;
        $this->request = $request;
        $this->kernel = $kernel;
    }

    /**
     * @param GetResponseForExceptionEvent $event
     */
    public function onKernelException(GetResponseForExceptionEvent $event): void
    {
        $exception = $event->getException();

        if ($exception instanceof HttpExceptionInterface && $exception->getStatusCode() === 404) {
            $request = $event->getRequest();

            $page = $this->entityManager->getRepository(CmsPage::class)
                ->findOneBy(['identifier' => substr($request->getPathInfo(), 1)]);
            if ($page) {
                $request = $this->request->getCurrentRequest();
                $path = [
                    'page'        => $page,
                    '_forwarded'  => $request->attributes,
                    '_controller' => 'App\Controller\CmsPageController:show',
                ];
                $subRequest = $request->duplicate(null, null, $path);
                $response = $this->kernel->handle($subRequest, HttpKernelInterface::SUB_REQUEST);

                $event->setResponse($response);
            }
        }
    }
}
