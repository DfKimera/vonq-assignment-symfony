<?php
/**
 * vonq-assignment-symfony
 * UsersAPITest.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinambá <aryel.tupinamba@lqdi.net>
 *
 * Created at: 02/09/18, 23:08
 */

namespace App\Tests\Functional;


class UsersAPITest extends ResourceTestCase {

	public function testUsersIndex() {

		$this->client->request('GET', '/users');

		$this->assertEquals(200, $this->client->getResponse()->getStatusCode());

		$contents = $this->client->getResponse()->getContent();

		$this->assertJson($contents);
		$payload = json_decode($contents);

		$this->assertGreaterThanOrEqual(1, sizeof($payload->data));

		$this->assertObjectHasAttribute('name', $payload->data[0]);
		$this->assertObjectHasAttribute('email', $payload->data[0]);

	}

	public function testUsersShow() {

		$this->client->request('GET', '/users/1?with=invites,connections');

		$this->assertEquals(200, $this->client->getResponse()->getStatusCode());

		$contents = $this->client->getResponse()->getContent();

		$this->assertJson($contents);
		$payload = json_decode($contents);

		$this->assertNotNull($payload->data);

		$this->assertObjectHasAttribute('name', $payload->data);
		$this->assertObjectHasAttribute('email', $payload->data);
		$this->assertObjectHasAttribute('invites', $payload->data);
		$this->assertObjectHasAttribute('connections', $payload->data);

	}

}