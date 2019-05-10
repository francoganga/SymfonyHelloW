<?php


namespace App\Controller;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Routing\Annotation\Route;

//use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\View\View;

use App\Entity\User;
use App\Form\RESTUserForm;

/**
 * User Controller.
 * @Route("/api")
 */
Class RESTController extends FOSRestController{
	 /**
   * Lists all users.
   * @Rest\Get("/usuarios")
   *
   * @return Response
   */
	public function getUsers(){
		$repository = $this->getDoctrine()->getRepository(User::class);
		$users = $repository->findall();
		return $this->handleView($this->view($users));
	}



	/**
   * Create User.
   * @Rest\Post("/usuarios")
   *
   * @return Response
   */
	public function postUser(Request $request){
		$user = new User();
		echo $request->get("username");
		$user->setUsername($request->get('username'));
		$user->setRoles($request->get('roles'));
		$user->setPassword($request->get('password'));
		$user->setEmail($request->get('email'));
		$em = $this->getDoctrine()->getManager();
		$em->persist($user);
		$em->flush();

		return View::create($user, Response::HTTP_CREATED , []);
	}
	/**
   * Create User.
   * @Rest\Get("/usuarios/{userId}")
   *
   * @return Response
   */
	public function getUsr(int $userId): View{
		$rep = $this->getDoctrine()->getRepository(User::class);
		$user = $rep->findById($userId);
		if (!$user){
			echo 'Username could not be found.';
		}
		return View::create($user, Response::HTTP_OK);

	}



}