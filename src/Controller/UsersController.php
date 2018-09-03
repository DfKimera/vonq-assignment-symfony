<?php
/**
 * vonq-assignment-symfony
 * UsersController.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinambá <aryel.tupinamba@lqdi.net>
 *
 * Created at: 02/09/18, 22:06
 */

namespace App\Controller;


use App\Repository\UserRepository;
use App\Transformers\UserTransformer;
use League\Fractal\Manager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UsersController extends ResourceController {

	/**
	 * @var UserRepository
	 */
	private $repository;

	public function __construct(UserRepository $repository, Manager $fractal) {
		parent::__construct($fractal);
		$this->repository = $repository;
	}

	/**
	 * @Route("/users", name="users")
	 * @param Request $request
	 * @return Response
	 */
	public function index(Request $request) {

		$users = $this->repository->findAll();

		return $this->resourceCollection(
			$users,
			new UserTransformer(),
			$request->get('with')
		);
	}

	/**
	 * @Route("/users/{id}", name="user_show")
	 * @param $id
	 * @param Request $request
	 * @return Response
	 */
	public function show($id, Request $request) {
		$user = $this->repository->find($id);

		if(!$user) {
			throw $this->createNotFoundException('User not found: ' . $id);
		}

		return $this->resourceItem(
			$user,
			new UserTransformer(),
			$request->get('with')
		);

	}

}