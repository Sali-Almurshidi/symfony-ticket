<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Ticket;
use App\Form\AddCommentWithPrivateFormType;
use App\Repository\TicketRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use \App\Entity\User;

class AgentOneController extends AbstractController
{
    const AGENT_LEVEL_ONE = 0;
    const AGENT_LEVEL_TOW = 1;
    const PUBLIC_STATUS = 0;
    const PRIVATE_STATUS = 1;


    /**
     * @Route("/agent/one", name="agent_one")
     */
    public function agentOneHomePage()
    {
        /**@var User $user */
        /**@var TicketRepository $em */
        $user = $this->getUser();

        // change open status to in progress and add the agent id
        if (isset($_POST['select'])) {
            $selectTicket = $_POST['select'];
            $selectTicket = $this->getDoctrine()->getRepository(Ticket::class)->findBy(['id' => $selectTicket]);
            $this->editStatusTicket($selectTicket[0], $user);
        }
        // chang the agent level from 0 to 1
        if (isset($_POST['send'])) {
            $selectTicket = $_POST['send'];
            $selectTicket = $this->getDoctrine()->getRepository(Ticket::class)->findBy(['id' => $selectTicket]);
            $this->editAgentLevel($selectTicket[0], $user);
        }

        return $this->render('agent_one/agentOneHomePage.html.twig', [
            'agentName' => $user->getFirstName(),
            'tickets' => $this->allOpenTickets(),
            'agentTickets' => $this->allAgentTickets($user)
        ]);
    }

    /**
     * @param User $agent
     */
    public function editStatusTicket($ticket, User $agent)
    {
        // change open to in progress and add agent id for specific ticket
        $em = $this->getDoctrine()->getManager();
        $ticketObject = $em->getRepository(Ticket::class)->find($ticket);
        if (!$ticketObject) {
            throw $this->createNotFOundException('No ticket found');
        }
        $ticketObject->setTicketStatus('inprogress');
        $ticketObject->setAgentId($agent);

        $em->flush();
    }


    /**
     * @param $ticket
     */
    public function editAgentLevel($ticket)
    {
        // change agent level from 0 to 1
        $em = $this->getDoctrine()->getManager();
        $ticketObject = $em->getRepository(Ticket::class)->find($ticket);
        if (!$ticketObject) {
            throw $this->createNotFOundException('No ticket found');
        }
        $ticketObject->setAgentLevel(self::AGENT_LEVEL_TOW);
        $em->flush();
    }

    /**
     * @return mixed
     */
    public function allOpenTickets()
    {
        // get all open ticket with agent level 0
        $em = $this->getDoctrine()->getRepository(Ticket::class);
        return $this->openTicket = $em->openTicketLevel('open', self::AGENT_LEVEL_ONE);
    }

    /**
     * @param User $user
     * @return mixed
     */
    public function allAgentTickets(User $user)
    {
        // get all in progress ticket with agent level 0
        $em = $this->getDoctrine()->getRepository(Ticket::class);
        return $this->openTicket = $em->openAgentTickets('inprogress', self::AGENT_LEVEL_ONE, $user);
    }

    /**
     * @Route("/agent/one/ticket{ticket}", name="agent_one_ticket")
     * @param Ticket $ticket
     * @return Response
     * @throws \Exception
     */
    public function ticketDetails(Ticket $ticket, Request $request)
    {

        /** @var Comment $comment */
        $comment = new Comment();
        $form = $this->createForm(AddCommentWithPrivateFormType::class, $comment);
        $form->handleRequest($request);



        if ($form->isSubmitted()) {

            $status = self::PUBLIC_STATUS;

            if ($form->getData()->getCommentStatus() != 0) {
                $status = self::PRIVATE_STATUS;
            }

            $comment->setCommentStatus($status);
            $comment->setTicketId($ticket);
            $comment->setDate(new \DateTime());
            $comment->setUserId($ticket->getAgentId());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($comment);
            $entityManager->flush();
        }

        $em = $this->getDoctrine()->getRepository(Comment::class);
        $comments = $em->getAllComments($ticket);
        //$comments = $this->getDoctrine()->getRepository(Comment::class)->findBy(['ticketId' => $ticket]);

        //var_dump($comments);
        $form = $form->createView();


        if (isset($_POST['close'])) {
           /**@var Comment $comments */
          //  var_dump($comments->getTicketId());
            $ticket->setCloseTime(new \DateTime());
            $ticket->setTicketStatus('close');
           // throw new \Exception('TODO: provide a valid redirect inside '.__FILE__);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($ticket);
            $entityManager->flush();
           // $comments[0]->getTicketId()->setCloseTime(new \DateTime());
            return $this->redirectToRoute('agent_one');
        }//else{
            return $this->render('agent_one/showTicket.html.twig',
                ['ticket' => $ticket,
                    'commentForm' => $form,
                    'comments' => $comments,
                    //'totalOpenTicket'=>$openResult

                ]);
      //  }

    }


}

