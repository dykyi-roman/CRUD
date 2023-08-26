<?php

declare(strict_types=1);

namespace Application\EventSubscriber;

use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

final class LogSubscriber implements EventSubscriberInterface
{
    public function __construct(private readonly LoggerInterface $logger)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            RequestEvent::class => 'onKernelRequest',
            ResponseEvent::class => 'onKernelResponse',
        ];
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        if (!$event->isMainRequest()) {
            return;
        }

        $request = $event->getRequest();
        if (!$this->isApiRequest($request->getRequestUri())) {
            return;
        }

        $this->logger->info(
            sprintf('Request: %s', $request->getRequestUri()), [
            'uri' => $request->getUri(),
            'content' => $request->request->all(),
        ],
        );
    }

    public function onKernelResponse(ResponseEvent $event): void
    {
        $request = $event->getRequest();
        if (!$this->isApiRequest($request->getRequestUri())) {
            return;
        }

        $content = $event->getResponse()->getContent();
        $this->logger->info(
            sprintf('Response: %s', $request->getRequestUri()),
            [
                'uri' => $event->getRequest()->getUri(),
                'content' => false === $content ? 'Response body is empty.' : $content,
                'httpCode' => $event->getResponse()->getStatusCode(),
            ],
        );
    }

    private function isApiRequest(string $uri): bool
    {
        return false !== \strripos($uri, '/api');
    }
}
