<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CustomerController extends AbstractController
{
    /**
     * @Route("/customer", name="customer")
     */
    public function customerHomePage()
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

       // $this->getUser()->getUsername();
        return $this->render('customer/customerHomePage.html.twig', [
            'controller_name' => $this->getUser()->getUsername(),
        ]);
    }
}
