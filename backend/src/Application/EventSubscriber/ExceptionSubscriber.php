<?php

declare(strict_types=1);

namespace Application\EventSubscriber;

use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final readonly class ExceptionSubscriber implements EventSubscriberInterface
{
    private const ERROR_CODE_LIST = [200, 201, 400, 401, 403];

    public function __construct(
        private LoggerInterface $logger,
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        $this->logger->error($exception->getMessage());
        $code = in_array($exception->getCode(), self::ERROR_CODE_LIST, true) ? $exception->getCode() : 500;
        $event->setResponse(
            new JsonResponse(['error' => $exception->getMessage(), 'code' => $exception->getCode()], min($code, 500)),
        );
    }
}
