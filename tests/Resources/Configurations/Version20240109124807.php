<?php

declare(strict_types=1);

namespace RichId\ConfigurationBundle\Tests\Resources\Configurations;

use RichId\ConfigurationBundle\Domain\Configuration\AbstractConfiguration;

final class Version20240109124807 extends AbstractConfiguration
{
    protected function checkIsSkipped(): bool
    {
        return true;
    }

    protected function execute(): void
    {
    }
}
