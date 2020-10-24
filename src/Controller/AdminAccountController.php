<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @IsGranted("ROLE_ADMIN")
 */
class AdminAccountController extends AbstractController
{
    /**
     * @Route("/admin/account", name="app_admin_account")
     */
    public function index()
    {
        return $this->render('admin_account/index.html.twig', [
            'controller_name' => 'AdminAccountController',
        ]);
    }
}
