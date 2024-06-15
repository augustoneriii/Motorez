<?php
namespace App\DAO;

use App\Models\Vehicle;
use App\DTOs\WebMotorsDTO;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\DBAL\Types\Types;
use Ramsey\Uuid\UuidInterface;

 class VehicleDAO
{
    private $connection;
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }
    public function insertWebMotors(array $webMotorsDTO): void
    {
        $this->connection->beginTransaction();
        try {
            foreach ($webMotorsDTO as $dto) {
                $this->connection->insert('vehicles', [
                    'id' => Uuid::uuid4()->toString(),
                    'marca' => $dto->marca,
                    'modelo' => $dto->modelo,
                    'ano' => $dto->ano,
                    'combustivel' => $dto->combustivel,
                    'km' => $dto->km,
                    'preco' => $dto->preco
                ]);
            }
            $this->connection->commit();
        } catch (DBALException $e) {
            $this->connection->rollBack();
            throw $e;
        }
    }
}