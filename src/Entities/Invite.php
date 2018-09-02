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

namespace App\Entities;


class Invite {

	const STATUS_ACCEPTED = "accepted";
	const STATUS_REJECTED = "rejected";
	const STATUS_PENDING = "pending";

	public $id;

	public $inviter_id;
	public $invited_id;

	private $status;

	public $created_at;

	public function getStatus() {
		return $this->status;
	}

	public function isPending() {
		return $this->status === self::STATUS_PENDING;
	}

	public function accept() {
		if(!$this->isPending()) {
			throw new \InvalidArgumentException("Cannot accept an invite that is not pending.");
		}

		$this->status = self::STATUS_ACCEPTED;
	}

	public function reject() {
		if(!$this->isPending()) {
			throw new \InvalidArgumentException("Cannot reject an invite that is not pending.");
		}

		$this->status = self::STATUS_REJECTED;
	}

	public static function create(string $inviter_id, string $invited_id) {
		$invite = new Invite();
		$invite->inviter_id = $inviter_id;
		$invite->invited_id = $invited_id;
		$invite->status = self::STATUS_PENDING;

		return $invite;
	}

}