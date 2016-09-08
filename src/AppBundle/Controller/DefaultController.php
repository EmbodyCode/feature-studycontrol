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
    public function listUsersAction()
    {
        $userManager = $this->get('fos_user.user_manager');
        $users = $userManager->findUsers();
        return $this->render('AppBundle:Admin:users.html.twig',array(''
            . 'users' => $users));
    }
    
    /**
     * @Route("/registration", name="reg")
     */
    public function regUserAction(Request $request)
    {
        if($request->getMethod()=="POST")
        {
            $userManager = $this->get('fos_user.user_manager');
            $user = $userManager->createUser();
            $username = $request->get('username');
            $password = $request->get('password');
            $email = $request->get('email');
            $createdAt = new \DateTime('now');
            $role = $request->get('role');
            
            $user->setUsername($username);
            $user->setEmail($email);
            $user->setPlainPassword($password);
            $user->setCreatedAt($createdAt);
            $user->addRole('ROLE_ADMIN');
            $user->setEnabled(true);
            $dm = $this->getDoctrine()->getManager();
            $dm->persist($user);
            $dm->flush();
            $msg = "Вы зарегистрировали пользователя";
            return $this->render('AppBundle:Admin:registration.html.twig',array(''
                . 'message' => $msg));
        }
            return $this->render('AppBundle:Admin:registration.html.twig');
        
    }
}
