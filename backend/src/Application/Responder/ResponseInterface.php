<?php

declare(strict_types=1);

namespace Application\Responder;

interface ResponseInterface
{
    public function getBody(): array;

    public function getStatusCode(): int;
}
