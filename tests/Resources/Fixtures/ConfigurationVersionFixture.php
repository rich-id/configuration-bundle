<?php

declare(strict_types=1);

namespace RichId\ConfigurationBundle\Tests\Resources\Fixtures;

use RichCongress\RecurrentFixturesTestBundle\DataFixture\AbstractFixture;
use RichId\ConfigurationBundle\Domain\Entity\ConfigurationVersion;
use RichId\ConfigurationBundle\Tests\Resources\Configurations\Version20240109124805;

final class ConfigurationVersionFixture extends AbstractFixture
{
    protected function loadFixtures(): void
    {
        $this->createObject(ConfigurationVersion::class, Version20240109124805::class, [
            'version'    => Version20240109124805::class,
            'executedAt' => new \DateTime('2024-01-01 00:00:00'),
        ]);
    }
}
