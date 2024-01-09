<?php

declare(strict_types=1);

namespace RichId\ConfigurationBundle\Tests\Resources;

use PHPUnit\Runner\AfterTestHook;
use PHPUnit\Runner\BeforeTestHook;

class PHPUnitExtension implements BeforeTestHook, AfterTestHook
{
    public function executeBeforeTest(string $test): void
    {
        TestFile::delete('tmp');
    }

    public function executeAfterTest(string $test, float $time): void
    {
        TestFile::delete('tmp');
    }
}
