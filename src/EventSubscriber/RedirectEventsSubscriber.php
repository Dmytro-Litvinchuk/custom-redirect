<?php

namespace Drupal\custom_redirect\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class RedirectEventsSubscriber
 *
 * @package Drupal\custom_redirect\EventSubscriber
 */
class RedirectEventsSubscriber implements EventSubscriberInterface {

  /**
   * @inheritDoc
   */
  public static function getSubscribedEvents() {
    $events[KernelEvents::REQUEST][] = ['checkForRedirection'];
    return $events;
  }

  /**
   * @return \Symfony\Component\HttpFoundation\RedirectResponse
   */
  public function checkForRedirection() {
    if (\Drupal::currentUser()->isAnonymous() && \Drupal::routeMatch()->getRouteName() !== 'user.login') {
      //Not working $event->setResponse(new RedirectResponse(Url::fromRoute('user.login')));
      // 301 redirect best for SEO.
      $response = new RedirectResponse("/user/login", 301, []);
      return $response->send();
    }
  }

}
