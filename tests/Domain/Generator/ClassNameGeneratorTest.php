<?php

declare(strict_types=1);

namespace RichId\ConfigurationBundle\Tests\Domain\Generator;

use RichCongress\TestSuite\TestCase\TestCase;
use RichId\ConfigurationBundle\Domain\Generator\ClassNameGenerator;

/** @covers \RichId\ConfigurationBundle\Domain\Generator\ClassNameGenerator*/
final class ClassNameGeneratorTest extends TestCase
{
    public function testGenerateClaseName(): void
    {
        self::assertMatchesRegularExpression('/^Version[0-9]{14}$/', ClassNameGenerator::generateClaseName());
    }
}
