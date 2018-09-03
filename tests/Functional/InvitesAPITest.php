<?php
/**
 * vonq-assignment-symfony
 * InvitesAPITest.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinambá <aryel.tupinamba@lqdi.net>
 *
 * Created at: 03/09/18, 00:06
 */

namespace App\Tests\Functional;


use App\Entity\Invite;
use App\Entity\User;

class InvitesAPITest extends ResourceTestCase {

	public function setUp() {
		parent::setUp();

		$userA = $this->em->getRepository(User::class)->find(1);
		$userB = $this->em->getRepository(User::class)->find(2);

		$existingInvite = Invite::create($userA, $userB);

		$this->em->persist($existingInvite);
		$this->em->flush();
	}

	public function testIndex() {

		$this->client->request('GET', '/invites', [], [], ['HTTP_Authorization' => 2]);

		$this->assertEquals(200, $this->client->getResponse()->getStatusCode());

		$contents = $this->client->getResponse()->getContent();

		$this->assertJson($contents);
		$payload = json_decode($contents);


		$this->assertCount(1, $payload->data);

		$this->assertObjectHasAttribute('inviter', $payload->data[0]);
		$this->assertObjectHasAttribute('id', $payload->data[0]->inviter);
		$this->assertObjectHasAttribute('name', $payload->data[0]->inviter);
		$this->assertObjectHasAttribute('email', $payload->data[0]->inviter);

	}

	public function testAccept() {

		$this->client->request('GET', '/invites', [], [], ['HTTP_Authorization' => 2]);
		$payload = json_decode($this->client->getResponse()->getContent());

		$this->assertCount(1, $payload->data);

		$existingInviteId = $payload->data[0]->id;

		$this->assertEquals('pending', $payload->data[0]->status);

		$this->client->request('PUT', '/invites/' . $existingInviteId, ['status' => 'accepted'], [], ['HTTP_Authorization' => 2]);
		$this->assertEquals(200, $this->client->getResponse()->getStatusCode());

		$contents = $this->client->getResponse()->getContent();

		$this->assertJson($contents);
		$payload = json_decode($contents);

		$this->assertEquals('ok', $payload->status);
		$this->assertEquals('accepted', $payload->invite_status);


	}

	public function testReject() {

		$this->client->request('GET', '/invites', [], [], ['HTTP_Authorization' => 2]);
		$payload = json_decode($this->client->getResponse()->getContent());

		$this->assertCount(1, $payload->data);

		$existingInviteId = $payload->data[0]->id;

		$this->assertEquals('pending', $payload->data[0]->status);

		$this->client->request('PUT', '/invites/' . $existingInviteId, ['status' => 'rejected'], [], ['HTTP_Authorization' => 2]);
		$this->assertEquals(200, $this->client->getResponse()->getStatusCode());

		$contents = $this->client->getResponse()->getContent();

		$this->assertJson($contents);
		$payload = json_decode($contents);

		$this->assertEquals('ok', $payload->status);
		$this->assertEquals('rejected', $payload->invite_status);


	}

}