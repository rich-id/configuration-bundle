<?php

declare(strict_types=1);

namespace RichId\ConfigurationBundle\Infrastructure;

use RichCongress\BundleToolbox\Configuration\AbstractBundle;

class RichIdConfigurationBundle extends AbstractBundle
{
    /** @var array<string, string> */
    protected static $doctrineAttributeMapping = [
        'RichId\\ConfigurationBundle\\Domain\\Entity' => __DIR__ . '/../Domain/Entity',
    ];
}
