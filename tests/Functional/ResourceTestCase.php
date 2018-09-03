<?php
/**
 * vonq-assignment-symfony
 * ResourceTestCase.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinambá <aryel.tupinamba@lqdi.net>
 *
 * Created at: 02/09/18, 23:11
 */

namespace App\Tests\Functional;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Console\Input\StringInput;

class ResourceTestCase extends WebTestCase {

	/**
	 * @var Client
	 */
	protected $client;

	/**
	 * @var EntityManager
	 */
	protected $em;

	/**
	 * @var Application
	 */
	protected static $application;

	public function setUp() {
		parent::setUp();

		$this->client = static::createClient();

		$this->em = static::$kernel
			->getContainer()
			->get('doctrine')
			->getManager();

		self::runCommand('doctrine:database:drop --force');
		self::runCommand('doctrine:database:create');
		self::runCommand('doctrine:schema:create');
		self::runCommand('doctrine:fixtures:load --append --no-interaction');
	}

	protected static function runCommand($command) {
		$command = sprintf('%s --quiet', $command);
		return self::getApplication()->run(new StringInput($command));
	}

	protected static function getApplication() {
		if (null === self::$application) {
			$client = static::createClient();

			self::$application = new Application($client->getKernel());
			self::$application->setAutoExit(false);
		}

		return self::$application;
	}

	protected function tearDown() {
		self::runCommand('doctrine:database:drop --force');

		parent::tearDown();

		$this->em->close();
		$this->em = null;
	}

}