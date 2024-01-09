<?php

declare(strict_types=1);

namespace RichId\ConfigurationBundle\Domain\Generator;

use RichId\ConfigurationBundle\Domain\Port\ConfigurationInterface;
use Symfony\Contracts\Service\Attribute\Required;

class NewConfigurationGenerator
{
    private const CONFIGURATION_TEMPLATE = <<<'TEMPLATE'
<?php

declare(strict_types=1);

namespace <namespace>;

use RichId\ConfigurationBundle\Domain\Configuration\AbstractConfiguration;

final class <className> extends AbstractConfiguration
{
    protected function execute(): void
    {
    }
}
TEMPLATE;

    #[Required]
    public ConfigurationInterface $configuration;

    public function __invoke(): string
    {
        $className = ClassNameGenerator::generateClaseName();

        $replacements = [
            '<namespace>' => $this->configuration->getConfigurationNamespace(),
            '<className>' => $className,
        ];

        if (!\is_dir($this->configuration->getConfigurationPath())) {
            \mkdir($this->configuration->getConfigurationPath(), 0755, true);
        }

        $path = \sprintf('%s/%s.php', $this->configuration->getConfigurationPath(), $className);

        file_put_contents($path, \strtr(self::CONFIGURATION_TEMPLATE, $replacements));

        return $path;
    }
}
