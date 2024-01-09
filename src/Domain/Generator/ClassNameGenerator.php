<?php

declare(strict_types=1);

namespace RichId\ConfigurationBundle\Domain\Generator;

class ClassNameGenerator
{
    public const VERSION_FORMAT = 'YmdHis';

    public static function generateClaseName(): string
    {
        return \sprintf('Version%s', self::generateVersionNumber());
    }

    private static function generateVersionNumber(): string
    {
        $now = new \DateTimeImmutable('now', new \DateTimeZone('UTC'));

        return $now->format(self::VERSION_FORMAT);
    }
}
