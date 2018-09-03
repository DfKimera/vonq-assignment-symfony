<?php
/**
 * vonq-assignment-symfony
 * Invite.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinambá <aryel.tupinamba@lqdi.net>
 *
 * Created at: 02/09/18, 18:28
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InviteRepository")
 */
class Invite {

	const STATUS_ACCEPTED = "accepted";
	const STATUS_REJECTED = "rejected";
	const STATUS_PENDING = "pending";

	/**
	 * @var integer
	 *
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="integer")
	 */
	public $id;

	/**
	 * @var User
	 *
	 * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="sentInvites", fetch="EAGER")
	 * @ORM\JoinColumn(name="inviter_id", referencedColumnName="id", nullable=false)
	 */
	private $inviter;

	/**
	 * @var User
	 *
	 * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="receivedInvites")
	 * @ORM\JoinColumn(name="invited_id", referencedColumnName="id", nullable=false)
	 */
	private $invited;

	/**
	 * @var string
	 * @ORM\Column(type="string")
	 * @Assert\NotBlank()
	 */
	private $status;

	/**
	 * @var \DateTime|null
	 * @ORM\Column(type="datetime")
	 */
	public $createdAt;

	/**
	 * Gets the status of the invite.
	 * @return string
	 */
	public function getStatus() {
		return $this->status;
	}

	/**
	 * Gets the user that sent the invite.
	 * @return User
	 */
	public function getInviter() {
		return $this->inviter;
	}

	/**
	 * Gets the user that received the invite.
	 * @return User
	 */
	public function getInvited() {
		return $this->invited;
	}

	/**
	 * Checks if the invite is still pending.
	 * @return bool
	 */
	public function isPending() {
		return $this->status === self::STATUS_PENDING;
	}

	/**
	 * Checks if the given user can decide to accept/reject this invite.
	 * @param User $user
	 * @return bool
	 */
	public function canBeDecidedBy(User $user) {
		return $this->invited->id === $user->id;
	}

	/**
	 * Accepts the invite.
	 */
	public function accept() {
		if(!$this->isPending()) {
			throw new \InvalidArgumentException("Cannot accept an invite that is not pending.");
		}

		$this->status = self::STATUS_ACCEPTED;
	}

	/**
	 * Rejects the invite.
	 */
	public function reject() {
		if(!$this->isPending()) {
			throw new \InvalidArgumentException("Cannot reject an invite that is not pending.");
		}

		$this->status = self::STATUS_REJECTED;
	}

	/**
	 * Creates a new user connection invite.
	 * @param User $inviter Who is inviting.
	 * @param User $invited Who is being invited.
	 * @return Invite
	 */
	public static function create(User $inviter, User $invited) {
		$invite = new Invite();
		$invite->inviter = $inviter;
		$invite->invited = $invited;
		$invite->status = self::STATUS_PENDING;
		$invite->createdAt = new \DateTime('now');

		return $invite;
	}

	public function __toString() {
		return "Invite@<{$this->id}, {$this->invited_id}, {$this->inviter_id}>";
	}

}