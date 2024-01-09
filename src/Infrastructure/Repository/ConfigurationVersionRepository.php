<?php

declare(strict_types=1);

namespace RichId\ConfigurationBundle\Infrastructure\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use RichId\ConfigurationBundle\Domain\Entity\ConfigurationVersion;

/** @extends ServiceEntityRepository<ConfigurationVersion> */
class ConfigurationVersionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ConfigurationVersion::class);
    }

    /** @return string[] */
    public function findAllVersions(): array
    {
        /** @var string[] $versions */
        $versions = $this->createQueryBuilder('cv')
            ->select('cv.version')
            ->getQuery()
            ->getSingleColumnResult();

        return $versions;
    }
}
