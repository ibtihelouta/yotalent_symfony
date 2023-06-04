<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    private $mailer;

    public function __construct(ManagerRegistry $registry, MailerInterface $mailer)
    {
        parent::__construct($registry, User::class);
        $this->mailer = $mailer;
    }

    public function save(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);

        $this->save($user, true);
    }

    public function findUser($Value, $order)
    {
        $em = $this->getEntityManager();
        if ($order == 'DESC') {
            $query = $em->createQuery(
                'SELECT r FROM App\Entity\User r   where r.nom like :suj OR r.email like :suj  order by r.id DESC '
            );
            $query->setParameter('suj', $Value . '%');
        } else {
            $query = $em->createQuery(
                'SELECT r FROM App\Entity\User r   where r.nom like :suj OR r.email like :suj  order by r.id ASC '
            );
            $query->setParameter('suj', $Value . '%');
        }
        return $query->getResult();
    }

    
    public function getUserByEmail($email)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.email = :email')
            ->setParameter('email', $email)
            ->getQuery()
            ->getOneOrNullResult();
    }

    
    public function getUserByResetCode($resetCode)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.resetCode = :resetCode')
            ->setParameter('resetCode', $resetCode)
            ->getQuery()
            ->getOneOrNullResult();
    }


    
    public function sendEmail($email, $message)
    {
        $email = (new Email())
            ->from('your_email@example.com')
            ->to($email)
            ->subject('Hello Email')
            ->html($message);

        $this->mailer->send($email);
    }

    
    public function updateUser($id, $nom, $email, $image)
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery(
            'UPDATE App\Entity\User u SET u.nom = :nom, u.email = :email, u.image = :image WHERE u.id = :id'
        );
        $query->setParameter('id', $id);
        $query->setParameter('nom', $nom);
        $query->setParameter('email', $email);
        $query->setParameter('image', $image);
        return $query->getResult();
    }

    
    public function getUserById($id)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }
}

