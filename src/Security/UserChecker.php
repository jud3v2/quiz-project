<?php

namespace App\Security;


use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Entity\User;

class UserChecker implements UserCheckerInterface
{
public function checkPreAuth(UserInterface $user)
{
if (!$user instanceof User) {
    return;
}

//if ($user->isDeleted()) {
// the message passed to this exception is meant to be displayed to the user
//throw new CustomUserMessageAccountStatusException('Your user account no longer exists.');
//}
}

public function checkPostAuth(UserInterface $user)
{
if (!$user instanceof User) {
return;
}

// user account is expired, the user may be notified
if ($user->getEmailConfirmation() != 1) {
throw new CustomUserMessageAuthenticationException('Vous devez activer votre compte en cliquant sur le lien qui vous a été envoyé par mail.');
}
}
}