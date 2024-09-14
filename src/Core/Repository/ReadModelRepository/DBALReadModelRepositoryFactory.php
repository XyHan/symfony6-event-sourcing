<?php

declare(strict_types=1);

namespace Core\Repository\ReadModelRepository;

use Broadway\ReadModel\Repository;
use Broadway\ReadModel\RepositoryFactory;
use Broadway\Serializer\Serializer;
use Doctrine\DBAL\Connection;

readonly class DBALReadModelRepositoryFactory implements RepositoryFactory
{
    public function __construct(
        private Connection $connection,
        private Serializer $serializer
    ) {}

    public function create(string $name, string $class): Repository
    {
        return new DBALReadModelRepository($this->connection, $this->serializer, $name, $class);
    }
}
