<?php
/**
 * vonq-assignment-symfony
 * InvitesController.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinambá <aryel.tupinamba@lqdi.net>
 *
 * Created at: 02/09/18, 23:51
 */

namespace App\Controller;


use App\Repository\InviteRepository;
use App\Repository\UserRepository;
use App\Service\InvitationService;
use App\Transformers\InviteTransformer;
use League\Fractal\Manager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InvitesController extends ResourceController {

	/**
	 * @var UserRepository
	 */
	private $users;

	/**
	 * @var InviteRepository
	 */
	private $invites;

	/**
	 * @var InvitationService
	 */
	private $invitationService;

	public function __construct(UserRepository $users, InviteRepository $invites, InvitationService $invitationService, Manager $fractal) {
		parent::__construct($fractal);

		$this->users = $users;
		$this->invites = $invites;
		$this->invitationService = $invitationService;
	}

	/**
	 * @Route("/invites", name="invites_received", methods={"GET"})
	 * @param Request $request
	 * @return Response
	 */
	public function index(Request $request) {

		$loggedUser = $this->getLoggedUser($request);

		if(!$loggedUser) {
			return $this->json(['status' => 'failed', 'reason' => 'login_required'], 403);
		}

		$invites = $this->invites->findUserReceivedInvites($loggedUser);

		return $this->resourceCollection(
			$invites,
			new InviteTransformer(),
			$request->get('with')
		);
	}

	/**
	 * @Route("/invites/{id}", name="invites_decide", methods={"PUT"})
	 * @param $id
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function changeStatus($id, Request $request) {

		$loggedUser = $this->getLoggedUser($request);

		if(!$loggedUser) {
			return $this->json(['status' => 'failed', 'reason' => 'login_required'], 403);
		}

		$newStatus = $request->get('status');

		if(!in_array($request->get('status'), ['accepted', 'rejected'])) {
			return $this->json(['status' => 'failed', 'reason' => 'invalid_status'], 422);
		}

		$invite = $this->invites->find($id);

		try {

			$invite = $newStatus === 'accepted'
				? $this->invitationService->acceptInvite($loggedUser, $invite)
				: $this->invitationService->rejectInvite($loggedUser, $invite);


		} catch (\Exception $e) {
			return $this->json(['status' => 'failed', 'reason' => $e->getMessage()], 422);
		}

		return $this->json(['status' => 'ok', 'invite_status' => $invite->getStatus()], 200);

	}

}