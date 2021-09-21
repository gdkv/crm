<?php

namespace App\Security\Voter;

use App\Entity\Application\Application;
use Psr\Log\LoggerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class UserlVoter extends Voter
{
    public function __construct(
        private Security $security,
        private LoggerInterface $logger,
    ){}

    protected function supports(string $attribute, $subject = null): bool
    {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, ['USERS_VIEW', 'USERS_CHECK'])) {
            return false;
        }

        // // only vote on `Post` objects
        // if ($subject && !$subject instanceof Application) {
        //     return false;
        // }

        return true;

    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof UserInterface) {
            return false;
        }    
  
        return match ($attribute) {
            'USERS_VIEW',
            'USERS_CHECK' => (
                $this->security->isGranted('ROLE_ADMIN') || 
                $this->security->isGranted('ROLE_SUPERVISOR') || 
                $this->security->isGranted('ROLE_OPERATOR') ||
                $this->security->isGranted('ROLE_CREDIT') ||
                $this->security->isGranted('ROLE_MANAGER') ||
                $this->security->isGranted('ROLE_RECEPTION') ||
                $this->security->isGranted('ROLE_GUEST')
            ),
            // 'APPLICATION_ADD',
            // 'APPLICATION_EDIT' => (
            //     $this->security->isGranted('ROLE_ADMIN') || 
            //     $this->security->isGranted('ROLE_MANAGER') ||
            //     $this->security->isGranted('ROLE_RECEPTION') ||
            //     $this->security->isGranted('ROLE_SUPERVISOR') ||
            //     $this->security->isGranted('ROLE_OPERATOR') 
            // ),
        };
    }
}
