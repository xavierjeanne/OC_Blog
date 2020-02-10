<?php

namespace Framework\Repository;

use Pagerfanta\Adapter\AdapterInterface;

/**
 * class paginatedquery to enable pagination for response
 */
class PaginatedQuery implements AdapterInterface
{
    /**
     * Undocumented variable
     *
     * @var \PDO pdo
     */
    private $pdo;

    /**
     * Undocumented variable
     *
     * @var string query
     */
    private $query;

    /**
     * Undocumented variable
     *
     * @var string countQuery
     */
    private $countQuery;

    /**
     * Undocumented variable
     *
     * @var string|null
     */
    private $entity;

    /**
     * Undocumented function
     * @param array $params
     */
    private $params;

    /**
     *
     * @param \PDO $pdo
     * @param string $query
     * @param string $countQuery
     * @param string|null $entity
     */
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

    public function getSlice($offset, $length): array
    {
        //prepare query with offset and length
        $query = $this->pdo->prepare($this->query . ' LIMIT :offset, :length');
        foreach ($this->params as $key => $param) {
            $query->bindParam($key, $param);
        }
        $query->bindParam('offset', $offset, \PDO::PARAM_INT);
        $query->bindParam('length', $length, \PDO::PARAM_INT);
        if ($this->entity) {
            //define query to be a class entity
            $query->setFetchMode(\PDO::FETCH_CLASS, $this->entity);
        }
        $query->execute();
        return $query->fetchAll();
    }
}
