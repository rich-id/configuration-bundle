<?php

declare(strict_types=1);

namespace RichId\ConfigurationBundle\Tests\Domain\Entity;

use RichCongress\TestFramework\TestConfiguration\Annotation\TestConfig;
use RichCongress\TestSuite\TestCase\TestCase;
use RichId\ConfigurationBundle\Domain\Entity\ConfigurationVersion;

/** @covers \RichId\ConfigurationBundle\Domain\Entity\ConfigurationVersion */
#[TestConfig('fixtures')]
final class ConfigurationVersionTest extends TestCase
{
    public function testEntity(): void
    {
        $date = new \DateTime();

        $entity = new ConfigurationVersion();
        $entity->setVersion('abc');
        $entity->setExecutedAt($date);

        self::assertSame('abc', $entity->getVersion());
        self::assertSame($date, $entity->getExecutedAt());
    }
}
