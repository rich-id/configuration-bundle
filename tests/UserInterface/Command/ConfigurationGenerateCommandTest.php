<?php

declare(strict_types=1);

namespace RichId\ConfigurationBundle\Tests\UserInterface\Command;

use RichCongress\TestFramework\TestConfiguration\Annotation\TestConfig;
use RichCongress\TestSuite\TestCase\CommandTestCase;
use RichId\ConfigurationBundle\Tests\Resources\Stub\ConfigurationAdapterStub;
use RichId\ConfigurationBundle\UserInterface\Command\ConfigurationGenerateCommand;

/**
 * @covers \RichId\ConfigurationBundle\Domain\Generator\ClassNameGenerator
 * @covers \RichId\ConfigurationBundle\Domain\Generator\NewConfigurationGenerator
 * @covers \RichId\ConfigurationBundle\UserInterface\Command\ConfigurationGenerateCommand
 */
#[TestConfig('fixtures')]
final class ConfigurationGenerateCommandTest extends CommandTestCase
{
    /** @var ConfigurationGenerateCommand */
    protected $command;

    public ConfigurationAdapterStub $configurationAdapterStub;

    protected function beforeTest(): void
    {
        /** @var ConfigurationGenerateCommand $command */
        $command = $this->getService(ConfigurationGenerateCommand::class);
        $this->command = $command;
    }

    public function testCommand(): void
    {
        $this->configurationAdapterStub->setConfigurationPath('/app/tests/Resources/Files/tmp');

        $output = $this->execute();

        self::assertStringContainsString('Generated new configuration class to', $output);
        self::assertStringContainsString('/tests/Resources/Files/tmp/', $output);
    }
}

