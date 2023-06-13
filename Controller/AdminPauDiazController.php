<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminPauDiazController extends AbstractController
{
    #[Route('/admin/pau/diaz', name: 'app_admin_pau_diaz')]
    public function index(): Response
    {
        return $this->render('admin_pau_diaz/index.html.twig', [
            'controller_name' => 'AdminPauDiazController',
        ]);
    }
}
