<?php

namespace App\Controller;
use App\Service\UploaderHelper;
use App\Entity\Calendar;
use App\Form\CalendarFormType;
use App\Repository\CalendarRepository;
use Gedmo\Sluggable\Util\Urlizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\UploadedFile;



/**
* @IsGranted("ROLE_ADMIN")
*/
class CalendarAdminController extends AbstractController
{
    /**
     * @Route("/admin/calendar/new", name="admin_calendar_new")
     */
    public function new(EntityManagerInterface $em, Request $request, UploaderHelper $uploaderHelper)
    {
        $form = $this->createForm(CalendarFormType::class);
        $form->handleRequest($request);#magic

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var @var Calendar $calendar */
            $calendar = $form->getData();
            $title = $calendar->getTitle();
            $calendar = $calendar->setSlug($title);
            $em->persist($calendar);
            $em->flush();
            $this->addFlash('success', 'Form created!');
            return $this->redirectToRoute('admin_calendar_list');
        }

        return $this->render('calendar_admin/new.html.twig', [
            'calendarForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/calendar/{id}/edit", name="admin_calendar_edit")
     */
    public function edit(Request $request, EntityManagerInterface $em, Calendar $calendar, UploaderHelper $uploaderHelper)
    {
        $form = $this->createForm(CalendarFormType::class, $calendar);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($calendar);
            $em->flush();

            $this->addFlash('success', 'Edited successfully!');

            return $this->redirectToRoute('admin_calendar_list', [
                'id' => $calendar->getId(),
            ]);
        }
        return $this->render('calendar_admin/edit.html.twig', [
            'calendarForm' => $form->createView(),
            'calendar' => $calendar,
        ]);
    }

    /**
     * @Route("/admin/calendar", name="admin_calendar_list")
     */
    public function list(CalendarRepository $calendarRepo)
    {
        $calendars = $calendarRepo->findAll();
        return $this->render('calendar_admin/list.html.twig', [
            'calendars' => $calendars,
        ]);
    }

}