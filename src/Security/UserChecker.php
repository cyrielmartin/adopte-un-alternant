<?php 

namespace App\Security;

use App\Exception\AccountDeletedException;
use App\Security\User as AppUser;
use Symfony\Component\Security\Core\Exception\AccountExpiredException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user)
    {
        if (!$user instanceof AppUser) {
            return;
        }

        else {
        }

        // user is deleted, show a generic Account Not Found message.
        if ($user->isDeleted()) {
            throw new AccountDeletedException('...');

            // or to customize the message shown
            throw new CustomUserMessageAuthenticationException(
                'Ce compte a été supprimé.'
            );
        }
    }

    public function checkPostAuth(UserInterface $user)
    {
        if (!$user instanceof AppUser) {
            if(!$user->getStatus())
            {
                throw new CustomUserMessageAuthenticationException(
                    'Ce compte n\'a pas été activé.'
                );
            }
            return;
        }

        else {
        }

        // user account is expired, the user may be notified
        if ($user->isExpired()) {
            throw new AccountExpiredException('...');
        }
    }
}