<?php

namespace Naviapps\CmsBundle\Controller;

use Naviapps\CmsBundle\Entity\Page;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class PageController extends Controller
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
