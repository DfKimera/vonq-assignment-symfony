<?php
/**
 * vonq-assignment-symfony
 * InviteTransformer.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinambá <aryel.tupinamba@lqdi.net>
 *
 * Created at: 02/09/18, 22:47
 */

namespace App\Transformers;


use App\Entity\Invite;
use League\Fractal\TransformerAbstract;

class InviteTransformer extends TransformerAbstract {

	public function transform(Invite $invite) {
		return [
			'id' => $invite->id,
			'created_at' => $invite->createdAt,
			'status' => $invite->getStatus(),
			'inviter' => $invite->getInviter(),
		];
	}

}