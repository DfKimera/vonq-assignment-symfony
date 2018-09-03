<?php
/**
 * vonq-assignment-symfony
 * UserTest.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinambá <aryel.tupinamba@lqdi.net>
 *
 * Created at: 02/09/18, 21:23
 */

namespace App\Tests\Unit;


use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class UserTest extends TestCase {

	/**
	 * @var User
	 */
	private $userA;

	/**
	 * @var User
	 */
	private $userB;

	public function setUp() {
		$this->userA = new User();
		$this->userA->id = 1;

		$this->userB = new User();
		$this->userB->id = 2;
	}

	public function testAddConnection() {
		$this->assertCount(0, $this->userA->getConnections());

		$this->userA->addConnection($this->userB);

		$this->assertCount(1, $this->userA->getConnections());
	}

	public function testRemoveConnection() {

		$this->userA->addConnection($this->userB);

		$this->assertCount(1, $this->userA->getConnections());

		$this->userA->removeConnection($this->userB);


		$this->assertCount(0, $this->userA->getConnections());
	}

	public function testRemoveReverseConnection() {

		$this->userA->addConnection($this->userB);

		$this->assertCount(1, $this->userA->getConnections());

		$this->userB->removeConnection($this->userA);

		$this->assertCount(0, $this->userA->getConnections());
	}

	public function testCannotConnectToItself() {

		$this->userA->addConnection($this->userA);

		$this->assertCount(0, $this->userA->getConnections());
	}

	public function testCannotConnectTwice() {

		$this->assertCount(0, $this->userA->getConnections());

		$this->userA->addConnection($this->userB);

		$this->assertCount(1, $this->userA->getConnections());

		$this->userA->addConnection($this->userB);

		$this->assertCount(1, $this->userA->getConnections());
	}

}