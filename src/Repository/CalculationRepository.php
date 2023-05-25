<?php

declare(strict_types=1);

namespace App\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ObjectRepository;

class CalculationRepository extends EntityRepository implements ObjectRepository
{
    public function deleteAll(): void
    {
        $this->createQueryBuilder('p')
            ->delete()
            ->getQuery()
            ->getResult();
    }
}