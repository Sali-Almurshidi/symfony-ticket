<?php

namespace App\Repository;

use App\Entity\Ticket;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Ticket|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ticket|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ticket[]    findAll()
 * @method Ticket[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TicketRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ticket::class);
    }

    // /**
    //  * @return Ticket[] Returns an array of Ticket objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    public function openTicketLevel(string $status ,int $level)
    {
        //show ticket status = 'open' && agent level = 0  for agent 1
        //show ticket status = 'open' && agent level = 1  for agent 2

        return $this->createQueryBuilder('t')
            ->andWhere('t.ticketStatus = :status')
            ->setParameter('status', $status)
            ->andWhere('t.agentLevel = :level')
            ->setParameter('level', $level)
            //->orderBy('t.id', 'ASC')
            //->setMaxResults(10)
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * @param string $status
     * @param int $level
     * @param User $user
     * @return mixed
     */
    public function openAgentTickets(string $status , int $level , User $user ){
        //show ticket status = 'inprogress' && agent level = 0  for agent 1 with agent id
        //show ticket status = 'inprogress' && agent level = 1  for agent 2 with agent id

        return $this->createQueryBuilder('t')
            ->andWhere('t.ticketStatus = :status')
            ->setParameter('status', $status)
            ->andWhere('t.agentLevel = :level')
            ->setParameter('level', $level)
            ->andWhere('t.agentId = :user')
            ->setParameter('user', $user)
            //->orderBy('t.id', 'ASC')
            //->setMaxResults(10)
            ->getQuery()
            ->getResult()
            ;
    }

  /*  public function countValueNumbers($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.ticketStatus = :val')
            ->setParameter('val', $value)
            ->select('count(t.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }*/

    /*
    public function findOneBySomeField($value): ?Ticket
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
