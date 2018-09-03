<?php
/**
 * vonq-assignment-symfony
 * InvitationService.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinambá <aryel.tupinamba@lqdi.net>
 *
 * Created at: 02/09/18, 19:21
 */

namespace App\Service;


use App\Entity\Invite;
use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;

class InvitationService {

	private $em;

	public function __construct(ObjectManager $entityManager) {
		$this->em = $entityManager;
	}

	/**
	 * Creates a connection invite from inviter to invited.
	 * @param User $inviter
	 * @param User $invited
	 * @return Invite
	 * @throws \Doctrine\ORM\ORMException
	 * @throws \Doctrine\ORM\OptimisticLockException
	 */
	public function inviteToConnect(User $inviter, User $invited) {

		$invite = Invite::create($inviter, $invited);

		$this->em->persist($invite);
		$this->em->flush();

		return $invite;

	}

	/**
	 * Accepts an invite.
	 * @param User $loggedUser
	 * @param Invite $invite
	 * @return Invite
	 * @throws \Doctrine\ORM\ORMException
	 * @throws \Doctrine\ORM\OptimisticLockException
	 * @throws \Exception
	 */
	public function acceptInvite(User $loggedUser, Invite $invite) {

		if(!$invite->canBeDecidedBy($loggedUser)) {
			throw new \Exception("User not authorized to accept invite.");
		}

		$invite->accept();

		$loggedUser->addConnection($invite->getInviter());

		$this->em->persist($invite);
		$this->em->persist($loggedUser);
		$this->em->flush();

		return $invite;

	}

	/**
	 * Rejects an invite.
	 * @param User $loggedUser
	 * @param Invite $invite
	 * @return Invite
	 * @throws \Doctrine\ORM\ORMException
	 * @throws \Doctrine\ORM\OptimisticLockException
	 * @throws \Exception
	 */
	public function rejectInvite(User $loggedUser, Invite $invite) {

		if(!$invite->canBeDecidedBy($loggedUser)) {
			throw new \Exception("User not authorized to accept invite.");
		}

		$invite->reject();

		$this->em->persist($invite);
		$this->em->flush();

		return $invite;

	}

}