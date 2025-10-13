<?php

namespace App\Security;

use App\Entity\Users;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class UserVoter extends Voter
{
   public const EDIT_PROFILE = 'EDIT_PROFILE';

   public function __construct(private AuthorizationCheckerInterface $auth)
   {
   }

   protected function supports(string $attribute, mixed $subject): bool
   {
      return $attribute === self::EDIT_PROFILE && $subject instanceof Users;
   }

   protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
   {
      $user = $token->getUser();

      if (!$user instanceof Users) {
         return false;
      }

      /** @var Users $profileUser */
      $profileUser = $subject;

      // Admins can edit any profile
      if ($this->auth->isGranted('ROLE_ADMIN')) {
         return true;
      }

      // A user can edit their own profile
      return $user === $profileUser;
   }
}
