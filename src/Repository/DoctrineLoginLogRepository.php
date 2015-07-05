<?php

namespace OxygenModule\Security\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Oxygen\Data\Pagination\PaginationService;
use Oxygen\Data\Repository\Doctrine\Repository;
use OxygenModule\Security\Entity\LoginLog;

class DoctrineLoginLogRepository extends Repository implements LoginLogRepositoryInterface {

    /**
     * The name of the entity.
     *
     * @var string
     */
    protected $entityName = LoginLog::class;

}