<?php

namespace Framework\Repository;

use Pagerfanta\Adapter\AdapterInterface;

class PaginatedQuery implements AdapterInterface
{
    /**
     * @var \PDO
     */
    private $pdo;

    /**
     * @var string
     */
    private $query;

    /**
     * @var string
     */
    private $countQuery;

    /**
     * @var string
     */
    private $model;

    public function __construct(\PDO $pdo, string $query, string $countQuery, string $model)
    {
        $this->pdo = $pdo;
        $this->query = $query;
        $this->countQuery = $countQuery;
        $this->model = $model;
    }

    public function getNbResults(): int
    {
        return $this->pdo->query($this->countQuery)->fetchColumn();
    }

    public function getSlice($offset, $length): array
    {
        //prepare query with offset and length
        $query = $this->pdo->prepare($this->query . ' LIMIT :offset, :length');
        $query->bindParam('offset', $offset, \PDO::PARAM_INT);
        $query->bindParam('length', $length, \PDO::PARAM_INT);
        $query->execute();
        $results = $query->fetchAll();
        $items = [];
        foreach ($results as $result) {
            $items[] = $this->model::createFromRow($result);
        }
        return $items;
    }
}
