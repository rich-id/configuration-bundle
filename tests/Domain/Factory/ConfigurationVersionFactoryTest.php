<?php

declare(strict_types=1);

namespace RichId\ConfigurationBundle\Tests\Domain\Factory;

use RichCongress\TestFramework\TestConfiguration\Annotation\TestConfig;
use RichCongress\TestSuite\TestCase\TestCase;
use RichId\ConfigurationBundle\Domain\Factory\ConfigurationVersionFactory;

/** @covers \RichId\ConfigurationBundle\Domain\Factory\ConfigurationVersionFactory */
#[TestConfig('fixtures')]
final class ConfigurationVersionFactoryTest extends TestCase
{
    public ConfigurationVersionFactory $configurationVersionFactory;

    public function testFactory(): void
    {
        $entity = ($this->configurationVersionFactory)('abc');

        self::assertSame('abc', $entity->getVersion());
        self::assertInstanceOf(\DateTime::class, $entity->getExecutedAt());
    }

    public function testFactoryWithCustomDate(): void
    {
        $date = new \DateTime();

        $entity = ($this->configurationVersionFactory)('abc', $date);

        self::assertSame('abc', $entity->getVersion());
        self::assertSame($date, $entity->getExecutedAt());
    }
}
