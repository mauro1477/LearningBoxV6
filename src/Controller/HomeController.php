<?php

namespace App\Controller;

use App\Repository\CalendarRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends AbstractController
{
    /**
     * @Route("/homepage", name="app_homepage")
     */
    public function homepage()
    {
        return $this->render('home/home_page.html.twig');
    }

    /**
     * @Route("homepage/calendar_show/{slug}", name="calendar_show")
     */
    public function show($slug)
    {

        return $this->render('home/show.html.twig', [
            'title' => ucwords(str_replace('-', ' ', $slug)),
        ]);
    }
}
