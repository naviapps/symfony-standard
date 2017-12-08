<?php

namespace App\EventListener;

use App\Repository\CmsPageRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class ExceptionListener
{
    /** @var CmsPageRepository */
    private $pageRepository;
    /** @var Request */
    private $request;
    /** @var HttpKernelInterface */
    private $kernel;

    /**
     * @param CmsPageRepository $pageRepository
     * @param HttpKernelInterface $kernel
     */
    public function __construct(CmsPageRepository $pageRepository, HttpKernelInterface $kernel)
    {
        $this->pageRepository = $pageRepository;
        $this->kernel = $kernel;
    }

    /**
     * @param GetResponseForExceptionEvent $event
     */
    public function onKernelException(GetResponseForExceptionEvent $event): void
    {
        $exception = $event->getException();

        if ($exception instanceof HttpExceptionInterface && $exception->getStatusCode() === 404) {
            $this->request = $event->getRequest();
            $identifier = substr($this->request->getPathInfo(), 1);

            $page = $this->pageRepository->findOneBy(['identifier' => $identifier]);
            if ($page) {
                $response = $this->forward('App\Controller\CmsPageController:show', ['page' => $page]);

                $event->setResponse($response);
            }
        }
    }

    /**
     * @param string $controller
     * @param array $path
     * @param array $query
     * @return Response
     */
    private function forward($controller, array $path = [], array $query = []): Response
    {
        $path['_forwarded'] = $this->request->attributes;
        $path['_controller'] = $controller;
        $subRequest = $this->request->duplicate($query, null, $path);

        return $this->kernel->handle($subRequest, HttpKernelInterface::SUB_REQUEST);
    }
}
