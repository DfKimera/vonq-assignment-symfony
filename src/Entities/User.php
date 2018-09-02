<?php
/**
 * vonq-assignment-symfony
 * User.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinambá <aryel.tupinamba@lqdi.net>
 *
 * Created at: 02/09/18, 18:27
 */

namespace App\Entities;


class User {

	public $id;
	public $name;
	public $email;

	protected $connections;
	protected $invites;

}