<?php

namespace App\Security;

use App\Entity\Tickets;
use App\Entity\Users;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class TicketVoter extends Voter
{
   public const DELETE = 'TICKET_DELETE';
   public const UPDATE_STATUS = 'TICKET_UPDATE_STATUS';
   public function __construct(private AuthorizationCheckerInterface $auth)
   {
   }

   protected function supports(string $attribute, mixed $subject): bool
   {
      return in_array($attribute, [self::DELETE, self::UPDATE_STATUS], true)
         && $subject instanceof Tickets;
   }

   protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
   {
      $user = $token->getUser();

      if (!$user instanceof Users) {
         return false;
      }

      /** @var Tickets $ticket */
      $ticket = $subject;

      // Admins can delete any ticket
      if ($this->auth->isGranted('ROLE_ADMIN')) {
         return true;
      }

      return match ($attribute) {
         // user can only delete their own ticket, no status update
         self::DELETE => $ticket->getUser() === $user,
         self::UPDATE_STATUS => false,
         default => false,
      };
   }
}
