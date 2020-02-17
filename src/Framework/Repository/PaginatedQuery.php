<?php

namespace Framework\Repository;

use Pagerfanta\Adapter\AdapterInterface;
use Framework\Repsoitory;
use Framework\Repository\Hydrator;

/**
 * class paginatedquery to enable pagination for response
 */
class PaginatedQuery implements AdapterInterface
{
    /**
     * @var \PDO pdo
     */
    private $pdo;

    /**
     * @var string query
     */
    private $query;

    /**
     * @var string countQuery
     */
    private $countQuery;

    /**
     * @var string|null
     */
    private $entity;

    /**
     * @param array
     */
    private $params;

    public function __construct(\PDO $pdo, string $query, string $countQuery, ?string $entity, array $params = [])
    {
        $this->pdo = $pdo;
        $this->query = $query;
        $this->countQuery = $countQuery;
        $this->entity = $entity;
        $this->params = $params;
    }
    
    public function getNbResults(): int
    {
        //if params send
        if (!empty($this->params)) {
            $query = $this->pdo->prepare($this->countQuery);
            $query->execute($this->params);
            return $query->fetchColumn();
        }
        return $this->pdo->query($this->countQuery)->fetchColumn();
    }

    public function getSlice($offset, $length)
    {
        //prepare query with offset and length
        $query = $this->pdo->prepare($this->query . ' LIMIT :offset, :length');
        foreach ($this->params as $key => $param) {
            $query->bindParam($key, $param);
        }
        $query->bindParam('offset', $offset, \PDO::PARAM_INT);
        $query->bindParam('length', $length, \PDO::PARAM_INT);
        $query->execute();
        $results = $query->fetchAll();
        $items=[];
        foreach ($results as $result) {
            $items[]=$this->entity::createFromRow($result);
        }
        return $items;
    }
}
