<?php

declare(strict_types=1);

namespace RichId\ConfigurationBundle\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table('configuration_versions')]
class ConfigurationVersion
{
    #[ORM\Id]
    #[ORM\Column(name: 'version', type: 'string')]
    protected string $version;

    #[ORM\Column(name: 'executed_at', type: 'datetime')]
    protected \DateTime $executedAt;

    public function getVersion(): string
    {
        return $this->version;
    }

    public function setVersion(string $version): self
    {
        $this->version = $version;

        return $this;
    }

    public function getExecutedAt(): \DateTime
    {
        return $this->executedAt;
    }

    public function setExecutedAt(\DateTime $executedAt): self
    {
        $this->executedAt = $executedAt;

        return $this;
    }
}
