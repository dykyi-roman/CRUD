<?php

declare(strict_types=1);

namespace Application\Responder\EventSubscriber;

use Application\Responder\ResponseInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class JsonResponderSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::VIEW => ['onKernelView'],
        ];
    }

    /**
     * @throws \JsonException
     */
    public function onKernelView(ViewEvent $viewEvent): void
    {
        $result = $viewEvent->getControllerResult();
        if (!$result instanceof ResponseInterface) {
            return;
        }

        $data = json_encode($result->getBody(), JSON_THROW_ON_ERROR);
        if (!is_string($data)) {
            throw new \JsonException('JSON encoded is failure.');
        }

        $viewEvent->setResponse(new JsonResponse(strlen($data) <= 2 ? '{}' : $data, $result->getStatusCode(), [], true));
    }
}
