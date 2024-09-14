<?php

declare(strict_types=1);

namespace Core\Repository\ReadModelRepository;

use Assert\Assertion;
use Assert\AssertionFailedException;
use Broadway\ReadModel\Identifiable;
use Broadway\ReadModel\Repository;
use Broadway\Serializer\Serializer;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Schema\SchemaException;
use Doctrine\DBAL\Schema\Table;

readonly class DBALReadModelRepository implements Repository
{
    public function __construct(
        private Connection $connection,
        private Serializer $serializer,
        private string $tableName,
        private string $class
    ) {}

    /**
     * @throws AssertionFailedException
     * @throws Exception
     */
    public function save(Identifiable $data): void
    {
        Assertion::isInstanceOf($data, $this->class);

        $this->connection->insert($this->tableName, [
            'uuid' => $data->getId(),
            'data' => json_encode($this->serializer->serialize($data)),
        ]);
    }

    /**
     * @param mixed $id
     *
     * @throws Exception
     */
    public function find($id): ?Identifiable
    {
        $row = $this->connection->fetchAssociative(sprintf('SELECT * FROM %s WHERE uuid = ?', $this->tableName), [$id]);
        if (false === $row) {
            return null;
        }

        return $this->serializer->deserialize(json_decode($row['data'], true));
    }

    /**
     * @throws Exception
     */
    public function findBy(array $fields): array
    {
        if (empty($fields)) {
            return [];
        }

        return array_values(array_filter($this->findAll(), function (Identifiable $readModel) use ($fields) {
            return $fields === array_intersect_assoc($this->serializer->serialize($readModel)['payload'], $fields);
        }));
    }

    /**
     * @throws Exception
     */
    public function findAll(): array
    {
        $rows = $this->connection->fetchAllAssociative(sprintf('SELECT * FROM %s', $this->tableName));

        return array_map(function (array $row) {
            return $this->serializer->deserialize(json_decode($row['data'], true));
        }, $rows);
    }

    public function remove($id): void
    {
        $this->connection->executeUpdate(sprintf('DELETE FROM %s WHERE uuid = ?', $this->tableName), [$id]);
    }

    /**
     * @throws SchemaException
     */
    public function configureSchema(Schema $schema): ?Table
    {
        if ($schema->hasTable($this->tableName)) {
            return null;
        }

        return $this->configureTable($schema);
    }

    /**
     * @throws SchemaException
     */
    public function configureTable(Schema $schema): Table
    {
        $table = $schema->createTable($this->tableName);
        $table->addColumn('uuid', 'guid', ['length' => 36]);
        $table->addColumn('data', 'text');
        $table->setPrimaryKey(['uuid']);

        return $table;
    }
}
