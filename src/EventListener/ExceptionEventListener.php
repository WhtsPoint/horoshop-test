<?php

namespace App\EventListener;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

#[AsEventListener(event: 'kernel.exception', priority: 100)]
readonly class ExceptionEventListener
{
    public function __construct(
        private string $appEnv
    ) {
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if ($this->appEnv === 'dev' && $exception instanceof HttpExceptionInterface === false) {
            return;
        }

        [$code, $message] = $exception instanceof HttpExceptionInterface === true
            ? [$exception->getStatusCode(), $exception->getMessage()]
            : [500, 'Something went wrong'];

        $event->setResponse(new JsonResponse(
                ['message' => $message],
                $code,
                ['Content-Type' => 'application/problem+json']
            )
        );
    }
}