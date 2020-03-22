<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Ticket;
use App\Form\AddCommentFormType;
use App\Form\AddTicketFormType;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use \App\Entity\User;
use Symfony\Component\Validator\Constraints\Date;

class CustomerController extends AbstractController
{
    /**
     * @Route("/customer", name="customer")
     *  * @param Request $request
     * @throws \Exception
     */
    public function customerHomePage(Request $request): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }
        /**@var User $user */
        $user = $this->getUser();
        $ticket = new Ticket();

        $form = $this->createForm(AddTicketFormType::class, $ticket);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $ticket->setReopen(0);
            $ticket->setTicketStatus('open');
            $ticket->setReopen(0);
            $ticket->setCustomerId($user);
            $ticket->setPriority(0);
            $ticket->setOpenTime(new \DateTime('@' . strtotime('now')));

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($ticket);
            $entityManager->flush();
        }

        $tickets = $this->getDoctrine()->getRepository(Ticket::class)->findBy(['customerId' => $user]);

        return $this->render('customer/customerHomePage.html.twig', [
            'customerName' => $user->getFirstName(),
            'tickets' => $tickets,
            'addTicketForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/ticketDetails{ticket}", name="customer_ticket")
     * @param Ticket $ticket
     * @param Request $request
     * @return Response
     */
    public function ticketDetails(Ticket $ticket, Request $request)
    {
        $comment = new Comment();
        $form = $this->createForm(AddCommentFormType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            $comment->setCommentStatus(0);
            $comment->setTicketId($ticket);
            $comment->setDate(new \DateTime());
            $comment->setUserId($ticket->getCustomerId());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($comment);
            $entityManager->flush();
        }

        $comments = $this->getDoctrine()->getRepository(Comment::class)->findBy(['ticketId' => $ticket]);
        //var_dump($comments);
        $form = $form->createView();

        if ($ticket->getTicketStatus() == 'close') {
            $form = null;
        }

        // $em = $this->getDoctrine()->getRepository(Ticket::class);
        // $openResult = $em->countValueNambers('open');

        return $this->render('customer/TicketDetails.html.twig',
            ['ticket' => $ticket,
                'commentForm' => $form,
                'comments' => $comments,
                //'totalOpenTicket'=>$openResult

            ]);


    }

}
