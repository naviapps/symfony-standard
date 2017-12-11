<?php

namespace Naviapps\CmsBundle\EventListener;

use Naviapps\CmsBundle\Repository\PageRepository;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class ExceptionListener
{
    /** @var PageRepository */
    private $pageRepository;
    /** @var RequestStack */
    private $requestStack;
    /** @var HttpKernelInterface */
    private $kernel;

    /**
     * @param PageRepository $pageRepository
     * @param RequestStack $requestStack
     * @param HttpKernelInterface $kernel
     */
    public function __construct(PageRepository $pageRepository, RequestStack $requestStack, HttpKernelInterface $kernel)
    {
        $this->pageRepository = $pageRepository;
        $this->requestStack = $requestStack;
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
            $identifier = substr($request->getPathInfo(), 1);

            $page = $this->pageRepository->findOneBy(['identifier' => $identifier]);
            if ($page) {
                $response = $this->forward('Naviapps\CmsBundle\Controller\PageController:show', ['page' => $page]);

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
    private function forward($controller, array $path = array(), array $query = array()): Response
    {
        $request = $this->requestStack->getCurrentRequest();
        $path['_forwarded'] = $request->attributes;
        $path['_controller'] = $controller;
        $subRequest = $request->duplicate($query, null, $path);

        return $this->kernel->handle($subRequest, HttpKernelInterface::SUB_REQUEST);
    }
}
