<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
    /**
     * @Route("/login", name="login")
     */
    public function index()
    {
        return $this->render('login/index.html.twig', [
            'controller_name' => 'LoginController',
        ]);
    }
}

/*id: int
customerId : manyToOne
title : string
date: date
openTime : dateTime
closeTime: dateTime
reopen : int
agentId: manyToOne
description : string
messages : oneToMany
ticketStatus : string
priority : int

id: int
ticketId: manyToOne
userId : manyToOne
content: text
date : date
commentStatus : int*/



