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

use App\Entities\Invite;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;


class InviteTest extends TestCase {

	public function testCreate() {
		$invite = Invite::create(uniqid(), uniqid());

		$this->assertEquals($invite->getStatus(), Invite::STATUS_PENDING);
	}

	public function testAccept() {
		$invite = Invite::create(uniqid(), uniqid());

		$invite->accept();

		$this->assertEquals($invite->getStatus(), Invite::STATUS_ACCEPTED);
		$this->assertNotEquals($invite->getStatus(), Invite::STATUS_REJECTED);
		$this->assertNotEquals($invite->getStatus(), Invite::STATUS_PENDING);

	}

	public function testReject() {
		$invite = Invite::create(uniqid(), uniqid());

		$invite->reject();

		$this->assertEquals($invite->getStatus(), Invite::STATUS_REJECTED);
		$this->assertNotEquals($invite->getStatus(), Invite::STATUS_ACCEPTED);
		$this->assertNotEquals($invite->getStatus(), Invite::STATUS_PENDING);
	}
}
