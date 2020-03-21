<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class NewPasswordController extends AbstractController
{
    /**
     * @Route("/new/password", name="new_password")
     */
    public function index()
    {
        return $this->render('new_password/index.html.twig', [
            'controller_name' => 'NewPasswordController',
        ]);
    }
}
