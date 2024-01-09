<?php

declare(strict_types=1);

namespace RichId\ConfigurationBundle\Tests\Domain\Port;

use RichCongress\TestFramework\TestConfiguration\Annotation\TestConfig;
use RichCongress\TestSuite\TestCase\TestCase;
use RichId\ConfigurationBundle\Domain\Port\ConfigurationVersionRepositoryInterface;

/**
 * @covers \RichId\ConfigurationBundle\Infrastructure\Adapter\ConfigurationAdapter
 * @covers \RichId\ConfigurationBundle\Infrastructure\Repository\ConfigurationVersionRepository
 */
#[TestConfig('fixtures')]
final class ConfigurationVersionRepositoryInterfaceTest extends TestCase
{
    public ConfigurationVersionRepositoryInterface $configurationVersionRepository;

    public function testFindAllVersions(): void
    {
        self::assertSame(['RichId\ConfigurationBundle\Tests\Resources\Configurations\Version20240109124805'], $this->configurationVersionRepository->findAllVersions());
    }
}
