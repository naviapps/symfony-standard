<?php

namespace App\Controller;

use App\Entity\CmsPage;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class CmsPageController extends Controller
{
    /**
     * @param CmsPage $page
     * @return Response
     */
    public function showAction(CmsPage $page): Response
    {
        return $this->render('cms_page/show.html.twig', ['page' => $page]);
    }
}
