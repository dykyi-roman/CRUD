<?php

declare(strict_types=1);

namespace Infrastructure\Uuid;

use Symfony\Component\Uid\UuidV4;

abstract readonly class AbstractUuid implements \Stringable
{
    protected UuidV4 $id;

    public function __construct(UuidV4 $id = null)
    {
        $this->id = $id ?? UuidV4::v4();
    }

    public static function fromString(string $id): self
    {
        return new static(UuidV4::fromString($id)); // @phpstan-ignore-line
    }

    protected function id(): UuidV4
    {
        return $this->id;
    }

    protected function equals(self $anId): bool
    {
        return $this->id === $anId->id();
    }

    public function __toString(): string
    {
        return $this->id->toRfc4122();
    }
}
