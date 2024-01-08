<?php

declare(strict_types=1);

namespace RichId\ConfigurationBundle\Domain\Factory;

use Doctrine\ORM\EntityManagerInterface;
use RichId\ConfigurationBundle\Domain\Entity\ConfigurationVersion;
use Symfony\Contracts\Service\Attribute\Required;

class ConfigurationVersionFactory
{
    #[Required]
    public EntityManagerInterface $entityManager;

    public function __invoke(string $version, ?\DateTime $executedAt = null): ConfigurationVersion
    {
        $entity = new ConfigurationVersion();

        $entity->setVersion($version);
        $entity->setExecutedAt($executedAt ?? new \DateTime());

        $this->entityManager->persist($entity);

        return $entity;
    }
}
