<?php

declare(strict_types=1);

namespace RichId\ConfigurationBundle\Domain\Helper;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\Service\Attribute\Required;

trait SqlConfigurationHelperTrait
{
    #[Required]
    public EntityManagerInterface $entityManager;

    protected function execSql(string $sql): void
    {
        $this->entityManager->getConnection()->executeQuery($sql);
    }
}
