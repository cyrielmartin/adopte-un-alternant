<?php

namespace App\Listener;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;

// Listener permettant de rediriger l'utilisateur après sa connexion sur le bon profil (selon s'il est candidat ou recruteur)

/**
 * Class AfterLoginRedirection
 *
 * @package App\AppListener
 */
class AfterLoginRedirection implements AuthenticationSuccessHandlerInterface
{
    private $router;

    /**
     * AfterLoginRedirection constructor.
     *
     * @param RouterInterface $router
     */
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    /**
     * @param Request        $request
     *
     * @param TokenInterface $token
     *
     * @return RedirectResponse
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        $roles = $token->getRoles();

        $rolesTab = array_map(function ($role) {
            return $role->getRole();
        }, $roles);

        if (in_array('ROLE_CANDIDATE', $rolesTab, true)) {
            // si c'est un candidat : on le redirige vers le profil candidat
            $redirection = new RedirectResponse($this->router->generate('candidate_profile'));
        } else {
            // sinon, c'est un recruteur, on le redirige vers le profil recruteur
            $redirection = new RedirectResponse($this->router->generate('recruiter_profile'));
        }

        return $redirection;
    }
}