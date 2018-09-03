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
use App\Service\InvitationService;
use App\Transformers\UserTransformer;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use League\Fractal\Manager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UsersController extends ResourceController {

	/**
	 * @var UserRepository
	 */
	private $repository;

	/**
	 * @var InvitationService
	 */
	private $invitationService;

	public function __construct(UserRepository $repository, InvitationService $invitationService, Manager $fractal) {
		parent::__construct($fractal);

		$this->repository = $repository;
		$this->invitationService = $invitationService;
	}

	/**
	 * @Route("/users", name="users", methods={"GET"})
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
	 * @Route("/users/{id}", name="user_show", methods={"GET"})
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

	/**
	 * @Route("/users/{id}/invites", name="users_invite_to_connect", methods={"POST"})
	 * @param $id
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function inviteToConnect($id, Request $request) {

		$loggedUserId = $request->headers->get('Authorization');

		$targetUser = $this->repository->find($id);
		$loggedUser = $this->repository->find($loggedUserId);

		try {
			$invite = $this->invitationService->inviteToConnect($loggedUser, $targetUser);
		} catch (\Exception $e) {
			return $this->json(['status' => 'failed', 'reason' => $e->getMessage()], 422);
		}

		return $this->json(['status' => 'ok', 'invite_id' => $invite->id], 201);

	}

}