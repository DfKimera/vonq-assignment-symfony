<?php
/**
 * vonq-assignment-symfony
 * Connection.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinambá <aryel.tupinamba@lqdi.net>
 *
 * Created at: 02/09/18, 18:27
 */

namespace App\Entities;


class Connection {

	public $user_a;
	public $user_b;

	public $created_at;

	public static function create(string $user_a, string $user_b) {

		if($user_a === $user_b) {
			throw new \InvalidArgumentException("Cannot connect a user to themselves");
		}

		$connection = new Connection();
		$connection->user_a = $user_a;
		$connection->user_b = $user_b;

		return $connection;
	}

}