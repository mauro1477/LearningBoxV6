<?php

namespace App\Controller;

use App\Entity\Calendar;
use App\Repository\CalendarRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends AbstractController
{
    /**
     * @Route("/homepage", name="app_homepage")
     */
    public function homepage(EntityManagerInterface $em, CalendarRepository $calendarRepo)
    {
//        $repository = $em->getRepository(Calendar::class);
//        $calendars = $repository->findAll();
//        return $this->render('home/home_page.html.twig', [
//            'calendars' => $calendars,
//
//        ]);

        $calendars = $calendarRepo->findAll();
        return $this->render('home/home_page.html.twig', [
            'calendars' => $calendars,

        ]);
    }

    /**
     * @Route("homepage/calendar_show/{slug}", name="calendar_show")
     */
    public function show(Calendar $calendar, $slug,EntityManagerInterface $em)
    {
//        $repository = $em->getRepository(Calendar::class);
//        /** @var Calendar $calendar */
//        $calendar = $repository->findOneBy(['slug' => $slug]);
//        if (!$calendar) {
//            throw $this->createNotFoundException(sprintf('No calendar for slug "%s"', $slug));
//        }
//        dd($calendar);
        return $this->render('home/show.html.twig', [
//            'title' => ucwords(str_replace('-', ' ', $slug)),
            'calendar' => $calendar,
        ]);
    }
}
