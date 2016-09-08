<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $session = $request->getSession();
        $user = $this->getUser();
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user->getUsername();
        return $this->render('AppBundle:Admin:index.html.twig',array(''
            . 'username' => $user->getUsername()));
    }
    
    /**
     * @Route("/users", name="users")
     */
    public function listUsers()
    {
        $userManager = $this->get('fos_user.user_manager');
        $users = $userManager->findUsers();
        return $this->render('AppBundle:Admin:users.html.twig',array(''
            . 'users' => $users));
        
        
    }
}
