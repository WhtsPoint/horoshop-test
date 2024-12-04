<?php

namespace App\EventListener;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

#[AsEventListener(event: 'kernel.exception', priority: 100)]
class ExceptionEventListener
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $event->setResponse(new JsonResponse(
                ['message' => 'Something went wrong'],
                500,
                ['Content-Type' => 'application/problem+json']
            )
        );
    }
}