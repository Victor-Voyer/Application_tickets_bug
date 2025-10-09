<?php

namespace App\EventListener;

use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class SessionTimeoutListener
{
   private int $timeout = 7200; // 2 hours

   public function __construct(
      private RequestStack $requestStack,
      private Security $security,
      private RouterInterface $router,
   ) {
   }

   public function onKernelRequest(RequestEvent $event): void
   {
      $request = $event->getRequest();
      $session = $request->getSession();

      // Only check for logged-in users
      if (!$session || !$this->security->getUser()) {
         return;
      }

      $lastActivity = $session->get('last_activity');

      if (!$lastActivity) {
         $session->set('last_activity', time());
         return;
      }

      if (time() - $lastActivity > $this->timeout) {
         $flashBag = $session->getBag('flashes');
         if($flashBag instanceof FlashBagInterface){
            $flashBag->add('error', 'Session timeout due to inactivity.');
         }
         $session->invalidate();
         $event->setResponse(new RedirectResponse($this->router->generate('app_login')));
         return;
      }

      $session->set('last_activity', time());
   }
}
