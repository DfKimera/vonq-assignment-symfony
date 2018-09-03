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
	protected $application;

	public function setUp() {
		parent::setUp();

		$this->client = static::createClient();

		$this->em = $this->client
			->getContainer()
			->get('doctrine')
			->getManager();

		$this->runCommand('doctrine:database:drop --force');
		$this->runCommand('doctrine:database:create');
		$this->runCommand('doctrine:schema:create');
		$this->runCommand('doctrine:fixtures:load --append --no-interaction');
	}

	protected function runCommand($command) {
		$command = sprintf('%s --quiet', $command);
		return $this->getApplication()->run(new StringInput($command));
	}

	protected  function getApplication() {
		if ($this->application === null) {
			$this->application = new Application($this->client->getKernel());
			$this->application->setAutoExit(false);
		}

		return $this->application;
	}

	protected function tearDown() {
		$this->runCommand('doctrine:database:drop --force');

		parent::tearDown();

		$this->em->close();
		$this->em = null;
	}

}