<?php

declare(strict_types=1);

namespace App\EventSubcriber;


use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class CustomApiResponseHeaderEventListener.
 */
#[AsEventListener(event: KernelEvents::RESPONSE, method: 'onKernelResponse')]
class CustomApiResponseHeaderEventListener
{
    public function onKernelResponse(ResponseEvent $event): void
    {
        $response = $event->getResponse();
        $response->headers->set('x-task', '1');
    }

}