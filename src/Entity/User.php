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

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User {

	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="integer")
	 */
	public $id;

	/**
	 * @ORM\Column(type="string", length=255)
	 * @Assert\NotBlank()
	 */
	public $name;

	/**
	 * @ORM\Column(type="string", length=255)
	 * @Assert\Email()
	 */
	public $email;

	/**
	 * @var User[]|ArrayCollection
	 *
	 * @ORM\ManyToMany(
	 *     targetEntity="App\Entity\User",
	 *     cascade={"persist"}
	 * )
	 * @ORM\JoinTable(name="user_connections")
	 */
	protected $connectedUsers;

	/**
	 * User constructor.
	 */
	public function __construct() {
		$this->connectedUsers = new ArrayCollection();
	}

	/**
	 * Gets the users that are connected to this user.
	 * @return User[]|ArrayCollection
	 */
	public function getConnections() {
		return $this->connectedUsers;
	}

	/**
	 * Adds a connection between two users.
	 * @param User $user The target user to connect
	 */
	public function addConnection(User $user) {

		// Prevent from adding a connection for the user to themselves.
		if($this->id === $user->id) {
			return;
		}

		// Check if this is already connected to given user.
		if($this->connectedUsers->contains($user)) {
			return;
		}

		// Checks if target user is already connected to given user.
		if($user->connectedUsers->contains($this)) {
			return;
		}

		$this->connectedUsers->add($user);

	}

	/**
	 * Removes a connection between two users.
	 * @param User $user The target user to disconnect from.
	 */
	public function removeConnection(User $user) {
		// Removes the relationship locally, if exists.
		$this->connectedUsers->removeElement($user);

		// Removes the relationship on the target, if exists.
		$user->connectedUsers->removeElement($this);
	}

}