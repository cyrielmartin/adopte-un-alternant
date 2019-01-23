<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('user/login.html.twig', [
            'error' => $error,
            'last_username' => $lastUsername,
        ]);
    }

    /**
     * @Route("/signup", name="signup", methods={"GET","POST"})
     */
    public function signup(Request $request, UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $em, GuardAuthenticatorHandler $guardHandler)
    {
        $user = new User();
      

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user = $form->getData();

            $user->setPassword($passwordEncoder->encodePassword(
                $user,
                $user->getPassword()
            ));

            $em->persist($user);
            $em->flush();
            $this->addFlash(
                'notice',
                'Inscription réussie !'
            );
            
            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                'main'
            );
        }

        return $this->render('user/signup.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);        
    }

}
