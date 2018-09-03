<?php
/**
 * vonq-assignment-symfony
 * ResourceController.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinambá <aryel.tupinamba@lqdi.net>
 *
 * Created at: 02/09/18, 22:32
 */

namespace App\Controller;


use App\Entity\User;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Serializer\DataArraySerializer;
use League\Fractal\TransformerAbstract;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class ResourceController extends AbstractController {

	private $fractal;

	public function __construct(Manager $fractal) {
		$this->fractal = $fractal;
		$this->fractal->setSerializer(new DataArraySerializer());
	}

	/**
	 * Gets the currently logged user in the request, or null if none.
	 * @param Request $request
	 * @return User|null
	 */
	public function getLoggedUser(Request $request) {

		if(!$request->headers->has('Authorization')) {
			return null;
		}

		$loggedUserId = $request->headers->get('Authorization');
		return $this->getDoctrine()->getRepository(User::class)->find($loggedUserId);
	}

	/**
	 * Returns a resource item, as transformed by the given transformer.
	 * @param $item
	 * @param TransformerAbstract $transformer
	 * @param null|string $includes
	 * @param int $statusCode
	 * @return Response
	 */
	protected function resourceItem($item, TransformerAbstract $transformer, ?string $includes = null, int $statusCode = 200) {

		$this->fractal->parseIncludes($includes ?? '');

		return new Response(
			$this->fractal->createData(new Item($item, $transformer))->toJson(),
			$statusCode
		);
	}

	/**
	 * Returns a resource collection, as transformed by the given transformer.
	 * @param $collection
	 * @param TransformerAbstract $transformer
	 * @param null|string $includes
	 * @param int $statusCode
	 * @return Response
	 */
	protected function resourceCollection($collection, TransformerAbstract $transformer, ?string $includes = null, int $statusCode = 200) {

		$this->fractal->parseIncludes($includes ?? '');

		return new Response(
			$this->fractal->createData(new Collection($collection, $transformer))->toJson(),
			$statusCode
		);
	}

}