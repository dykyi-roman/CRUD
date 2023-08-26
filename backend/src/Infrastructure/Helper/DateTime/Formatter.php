<?php

namespace Infrastructure\Helper\DateTime;

final readonly class Formatter
{
    private const FORMAT = 'c';

    public static function transform(\DateTimeImmutable $date): string
    {
        return $date->format(self::FORMAT);
    }
}
