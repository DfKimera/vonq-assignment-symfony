<?php
/**
 * vonq-assignment-symfony
 * ConnectionTest.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinambá <aryel.tupinamba@lqdi.net>
 *
 * Created at: 02/09/18, 19:39
 */

namespace App\Tests\Unit;

use App\Entities\Connection;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class ConnectionTest extends TestCase {

	public function testCreate() {

		$connection = Connection::create(uniqid(), uniqid());

		$this->assertNotNull($connection->user_a);
		$this->assertNotNull($connection->user_b);
		$this->assertNotEquals($connection->user_a, $connection->user_b);

	}

	public function testFailsIfSameUser() {

		$this->expectException(\InvalidArgumentException::class);

		$user_id = uniqid();

		Connection::create($user_id, $user_id);

	}
}
