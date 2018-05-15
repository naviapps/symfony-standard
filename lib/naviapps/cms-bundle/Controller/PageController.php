<?php

namespace Naviapps\Bundle\CmsBundle\Controller;

use Naviapps\Bundle\CmsBundle\Entity\Page;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class PageController extends AbstractController
{
    /**
     * @param Page $page
     * @return Response
     */
    public function show(Page $page): Response
    {
        return $this->render('@NaviappsCms/Page/show.html.twig', ['page' => $page]);
    }
}
