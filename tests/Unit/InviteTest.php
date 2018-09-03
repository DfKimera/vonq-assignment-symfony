<?php
/**
 * vonq-assignment-symfony
 * InviteTest.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinambá <aryel.tupinamba@lqdi.net>
 *
 * Created at: 02/09/18, 19:27
 */

namespace App\Tests\Unit;

use App\Entity\Invite;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;


class InviteTest extends TestCase {

	public function testCreate() {
		$userA = $this->createMock(User::class);
		$userB = $this->createMock(User::class);

		$invite = Invite::create($userA, $userB);

		$this->assertEquals($invite->getStatus(), Invite::STATUS_PENDING);
	}

	public function testAccept() {
		$userA = $this->createMock(User::class);
		$userB = $this->createMock(User::class);

		$invite = Invite::create($userA, $userB);

		$invite->accept();

		$this->assertEquals($invite->getStatus(), Invite::STATUS_ACCEPTED);
		$this->assertNotEquals($invite->getStatus(), Invite::STATUS_REJECTED);
		$this->assertNotEquals($invite->getStatus(), Invite::STATUS_PENDING);

	}

	public function testReject() {
		$userA = $this->createMock(User::class);
		$userB = $this->createMock(User::class);

		$invite = Invite::create($userA, $userB);

		$invite->reject();

		$this->assertEquals($invite->getStatus(), Invite::STATUS_REJECTED);
		$this->assertNotEquals($invite->getStatus(), Invite::STATUS_ACCEPTED);
		$this->assertNotEquals($invite->getStatus(), Invite::STATUS_PENDING);
	}
}
