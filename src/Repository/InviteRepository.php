<?php
/**
 * vonq-assignment-symfony
 * InviteRepository.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinambá <aryel.tupinamba@lqdi.net>
 *
 * Created at: 02/09/18, 21:19
 */

namespace App\Repository;


use App\Entity\Invite;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class InviteRepository extends ServiceEntityRepository {

	public function __construct(ManagerRegistry $registry) {
		parent::__construct($registry, Invite::class);
	}

	public function findUserReceivedInvites(User $user) {
		return $this->findBy(['invited' => $user]);
	}

	public function findUserSentInvites(User $user) {
		return $this->findBy(['inviter' => $user]);
	}

}