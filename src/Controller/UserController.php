<?php

namespace App\Controller;

use App\Entity\Role;
use App\Entity\User;
use App\Form\UserType;
use App\Entity\VisitCard;
use App\Entity\IsCandidate;
use App\Entity\IsRecruiter;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\Boolean;
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
     * @Route("/connexion", name="login")
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
     * @Route("/confirmation-compte{token}", name="account_confirm")
     */
    public function accountConfirm(string $token)
    {
        $entityManager = $this->getDoctrine()->getManager();
        
        $user = $entityManager->getRepository(User::class)->findOneByToken($token); 

        if($user != null) 
        {
            $user->setToken(null);
            $user->setStatus(1);
            $entityManager->flush();
            $this->addFlash('notice', 'Votre compte a été activé !');
        } 
        else 
        {
            $this->addFlash('danger', 'Le compte a déjà été validé. Veuillez vous connecter.');
        }
        return $this->redirectToRoute('login');
    }

    /**
     * @Route("/inscription", name="signup", methods={"GET","POST"})
     */
    public function signup(\Swift_Mailer $mailer, Request $request, UserPasswordEncoderInterface $passwordEncoder, TokenGeneratorInterface $tokenGenerator)
    {
        $em = $this->getDoctrine()->getManager();
        
        $user = new User();
        $user->setStatus(0);

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $token = $tokenGenerator->generateToken();
            
            $user = $form->getData();
            $user
                ->setPassword(
                    $passwordEncoder->encodePassword(
                        $user,
                        $user->getPassword()
                    ))
                ->setToken($token);

            // j'ajoute le user en base et le refresh pour mettre à jour l'objet avec son id
            $em->persist($user);
            $em->flush($user);
            $em->refresh($user);

            $role = $user->getRole()->getCode();

            if($role === 'ROLE_RECRUITER')
            {
                // je créer un objet is recruiter et l'affilie au user de type recruteur
                $isRecruiter = new IsRecruiter();
                $isRecruiter->setUser($user);
                $em->persist($isRecruiter);
            }
            else if($role === 'ROLE_CANDIDATE')
            {
                // je créer un objet is candidate et l'affilie au user de type candidat
                $isCandidate = new IsCandidate();
                $isCandidate->setUser($user);
                
                // je l'enregistre et refresh pour mettre à jour l'objet avec son id
                $em->persist($isCandidate);
                $em->flush($isCandidate);
                $em->refresh($isCandidate);
                
                // je crée un objet carte de visite et l'affilie au candidat
                $visitCard = new VisitCard();
                $visitCard
                    ->setIsCandidate($isCandidate)
                    ->setAdopted(0)
                    ->setVisibilityChoice(0);
                
                $em->persist($visitCard);
            }
            // j'envoie tout en base
            $em->flush();

            $url = $this->generateUrl('account_confirm', array('token' => $token), UrlGeneratorInterface::ABSOLUTE_URL);

            $message = (new \Swift_Message('Validez votre inscription'))
                ->setFrom('adoptealternant@gmail.com')
                ->setTo($user->getEmail())
                ->setBody(
                $this->renderView(
                    'emails/registration.html.twig',[
                        'user'=>$user,
                        'url'=>$url
                    ]
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
     * @Route("/mot-de-passe-oublie", name="pass_forgotten", methods={"GET","POST"})
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
                return $this->redirectToRoute('home');
            }
 
            $url = $this->generateUrl('pass_recover', array('token' => $token), UrlGeneratorInterface::ABSOLUTE_URL);
 
            $message = (new \Swift_Message('Mot de passe oublié'))
                ->setFrom('adoptealternant@gmail.com')
                ->setTo($user->getEmail())
                ->setBody(
                    $this->renderView(
                        'emails/pass_recover.html.twig',
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
        return $this->render('user/pass_forgotten.html.twig');
    }  

    /**
     * @Route("/nouveau-mot-de-passe{token}", name="pass_recover", methods={"GET","POST"})
     */

    public function passRecover(Request $request, string $token, UserPasswordEncoderInterface $passwordEncoder)
    {
        $pass = $request->get('password');
        $passConfirm = $request->get('password_confirm');
        
        if( !empty($pass) && !empty($passConfirm))
        {
            if($pass === $passConfirm)
            {
                $entityManager = $this->getDoctrine()->getManager();
        
                $user = $entityManager->getRepository(User::class)->findOneByToken($token);

                if($user === null) 
                {
                    $this->addFlash('danger', 'Le lien servant à modifier ce mot de passe a déjà été utilisé. Veuillez cliquer à nouveau sur "mot de passe oublié.');
                    return $this->redirectToRoute('login');
                }

                $user->setToken(null);
                $user->setPassword($passwordEncoder->encodePassword($user, $request->request->get('password')));
                $entityManager->flush();

                $this->addFlash('notice', 'Le mot de passe a bien été modifié');

                return $this->redirectToRoute('login');
            }
            else
            {
                $this->addFlash('danger', 'Les mots de passe saisis ne correspondent pas.');
                return $this->render('user/pass_recover.html.twig');
            }   
        } 
        else 
        {
            return $this->render('user/pass_recover.html.twig');
        }
    }
}