<?php
/**
 * vonq-assignment-symfony
 * UserTransformer.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinambá <aryel.tupinamba@lqdi.net>
 *
 * Created at: 02/09/18, 22:20
 */

namespace App\Transformers;


use App\Entity\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract {

	protected $availableIncludes = [
		'connections',
		'invites',
	];

	public function transform(User $user) {
		return [
			'id' => $user->id,
			'name' => $user->name,
			'email' => $user->email,
		];
	}

	public function includeConnections(User $user) {
		return $this->collection($user->getConnections(), new UserTransformer, 'connections');
	}

	public function includeInvites(User $user) {
		return $this->collection($user->getReceivedInvites(), new InviteTransformer, 'invites');
	}

}