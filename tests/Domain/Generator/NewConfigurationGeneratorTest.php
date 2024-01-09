<?php

declare(strict_types=1);

namespace RichId\ConfigurationBundle\Tests\Domain\Generator;

use RichCongress\TestFramework\TestConfiguration\Annotation\TestConfig;
use RichCongress\TestSuite\TestCase\TestCase;
use RichId\ConfigurationBundle\Domain\Generator\NewConfigurationGenerator;
use RichId\ConfigurationBundle\Tests\Resources\Stub\ConfigurationAdapterStub;

/** @covers \RichId\ConfigurationBundle\Domain\Generator\NewConfigurationGenerator*/
#[TestConfig('fixtures')]
final class NewConfigurationGeneratorTest extends TestCase
{
    public NewConfigurationGenerator $newConfigurationGenerator;

    public ConfigurationAdapterStub $configurationAdapterStub;

    public function testGenerator(): void
    {
        $this->configurationAdapterStub->setConfigurationPath('/app/tests/Resources/Files/tmp');

        $path = ($this->newConfigurationGenerator)();

        self::assertStringContainsString('/tests/Resources/Files/tmp/Version', $path);
    }
}
