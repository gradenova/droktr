<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Lists;

class DashController extends AbstractController {
	
	public function lists() {
		if (!$this->get('security.authorization_checker')->isGranted('ROLE_USER')) {
    	return $this->redirectToRoute('Home');}
		
		$user = $this->getUser();
		$lists = $user->getLists();
		return $this->render('dash/lists.twig', ['lists' => $lists]);}
	
	public function list($slug) {
		
		if (!$this->get('security.authorization_checker')->isGranted('ROLE_USER')) {
    	return $this->redirectToRoute('Home');}
		
		$list = $this->getDoctrine()->getRepository(Lists::class)->find($slug);
		
		$this->denyAccessUnlessGranted('view', $list);
		return $this->render('dash/list.twig', ['list' => $list]);}
	
	public function profile(Request $request) {
		if (!$this->get('security.authorization_checker')->isGranted('ROLE_USER')) {
    	return $this->redirectToRoute('Home');}
		
		$user = $this->getUser();
		$grav_url = "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $user->getEmail() ) ) ) . "?s=500";
		//$form = $this->createForm(UpdateUserType::class, $user);
		//$form->handleRequest($request);
		
		//if ($form->isSubmitted() && $form->isValid()) {	
	//		return $this->render('dash/profile.twig', ['form' => $form->createView(), 'grav' => $grav_url]);
	//	}
		
		return $this->render('dash/profile.twig', [
		//	'form' => $form->createView(),
			'grav' => $grav_url
		]);}
	
}