<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\RoleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

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
    public function signup(\Swift_Mailer $mailer, Request $request, RoleRepository $roleRepo, UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $em)
    {
        $user = new User();
        $role = $roleRepo->findOneBy(['code'=>'ROLE_CANDIDATE']);
        $user->setRole($role);

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
            $message = (new \Swift_Message('Validez votre inscription'))
            ->setFrom('adoptealternant@gmail.com')
            ->setTo($user->getEmail())
            ->setBody(
                $this->renderView(
                    'emails/registration.html.twig',
                    ['user'=>$user]
                ),
                'text/html'
            );
            $mailer->send($message); 
            $this->addFlash(
                'notice',
                'Un email vient de vous être envoyé. Veuillez cliquer sur le lien qu\'il contient pour finaliser votre inscription.'
            );

            return $this->redirectToRoute('login');
        }

        return $this->render('user/signup.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);        
    }

    /**
     * @Route("/pass-forgotten", name="pass_forgotten", methods={"GET","POST"})
     */

    public function passForgotten(Request $request, UserPasswordEncoderInterface $passwordEncoder, \Swift_Mailer $mailer, TokenGeneratorInterface $tokenGenerator)
    {
        if ($request->isMethod('POST')) {
 
            $email = $request->request->get('email');
 
            $entityManager = $this->getDoctrine()->getManager();
            $user = $entityManager->getRepository(User::class)->findOneByEmail($email);

            if ($user === null) {
                $this->addFlash('danger', 'Email Inconnu');
                return $this->redirectToRoute('pass_forgotten');
            }
            $token = $tokenGenerator->generateToken();
 
            try{
                $user->setToken($token);
                $entityManager->flush();
            } catch (\Exception $e) {
                $this->addFlash('warning', $e->getMessage());
                return $this->redirectToRoute('homepage');
            }
 
            $url = $this->generateUrl('pass_recover', array('token' => $token), UrlGeneratorInterface::ABSOLUTE_URL);
 
            $message = (new \Swift_Message('Mot de passe oublié'))
                ->setFrom('adoptealternant@gmail.com')
                ->setTo($user->getEmail())
                ->setBody(
                    $this->renderView(
                        'emails/passRecover.html.twig',
                        ['user'=>$user,
                        'url' => $url,
                        ]
                    ),
                    'text/html'
                );
            $mailer->send($message);
 
            $this->addFlash('notice', 'Un email vient de vous être envoyé. Veuillez cliquer sur le lien qu\'il contient pour regénérer votre mot de passe.');
 
            return $this->redirectToRoute('login');
        }
        return $this->render('user/passForgotten.html.twig');
    }  

    /**
     * @Route("/pass-recover{token}", name="pass_recover", methods={"GET","POST"})
     */

    public function passRecover(Request $request, string $token, UserPasswordEncoderInterface $passwordEncoder)
    {
        if ($request->isMethod('POST')) {
            $entityManager = $this->getDoctrine()->getManager();
 
            $user = $entityManager->getRepository(User::class)->findOneByToken($token);
 
            if ($user === null) {
                $this->addFlash('danger', 'Le mot de passe associé à cet email a déjà été modifié. Veuillez vous connecter.');
                return $this->redirectToRoute('login');
            }
 
            $user->setToken(null);
            $user->setPassword($passwordEncoder->encodePassword($user, $request->request->get('password')));
            $entityManager->flush();
 
            $this->addFlash('notice', 'Mot de passe mis à jour');
 
            return $this->redirectToRoute('login');
        } else {
            return $this->render('user/passRecover.html.twig');
        }
    }

}
