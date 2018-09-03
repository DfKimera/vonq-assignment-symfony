<?php
/**
 * vonq-assignment-symfony
 * AppFixtures.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinambá <aryel.tupinamba@lqdi.net>
 *
 * Created at: 02/09/18, 21:53
 */

namespace App\DataFixtures;


use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture {

	public function load(ObjectManager $manager) {

		$users = ['lorem', 'ipsum', 'dolor', 'sit', 'amet'];

		foreach($users as $userName) {
			$user = new User();
			$user->name = $userName;
			$user->email = "{$userName}@example.com";

			$manager->persist($user);
		}

		$manager->flush();

	}

}