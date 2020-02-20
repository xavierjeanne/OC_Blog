<?php

namespace Framework\Repository;

use PDO;
use Pagerfanta\Pagerfanta;
use Framework\Repository\PaginatedQuery;

class Repository
{
    /**
     * @var \PDO
     */
    protected $pdo;

    /**
     * @var string
     */
    protected $table;

    /**
     * @var string
     */
    protected $entity;

    /**
     * @var string
     */
    protected $model;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findAll(): array
    {
        $query = $this->pdo->query("SELECT * FROM  $this->table");
        $query->setFetchMode(\PDO::FETCH_CLASS, $this->entity);

        return $query->fetchAll();
    }

    public function find(int $id)
    {
        $query = $this->pdo->prepare("SELECT * FROM  $this->table WHERE id=?");
        $query->execute([$id]);
        return $query->fetch();
    }

    public function findPaginated(int $perPage, int $currentPage): Pagerfanta
    {
        //get all posts and make pagination and pass entity use(can now use datetime)
        $query = new PaginatedQuery(
            $this->pdo,
            $this->paginationQuery(),
            $this->countQuery(),
            $this->model
        );

        //return instance of pagerfanta withresult of query
        return (new Pagerfanta($query))->setMaxPerPage($perPage)->setCurrentPage($currentPage);
    }

    protected function paginationQuery(): string
    {
        return 'SELECT * FROM ' . $this->table;
    }

    protected function countQuery(): string
    {
        return 'SELECT COUNT(id) FROM ' . $this->table;
    }

    public function update(int $id, array $params): bool
    {
        //craete array with fields to update in request sql, array_map on params to dertiminate field
        $fieldQuery = $this->buildFieldQuery($params);
        //create params id (id of the post to update)
        $params['id'] = $id;
        //create request sql
        $query = $this->pdo->prepare("UPDATE $this->table SET $fieldQuery WHERE id=:id");

        return $query->execute($params);
    }

    public function insert(array $params): bool
    {
        //craete array with fields to update in request sql, array_map on params to dertiminate field
        $fieldQuery = $this->buildFieldQuery($params);
        //create request sql
        $query = $this->pdo->prepare("INSERT INTO $this->table SET $fieldQuery");

        return $query->execute($params);
    }

    public function delete(int $id): bool
    {
        $query = $this->pdo->prepare("DELETE FROM $this->table WHERE id=?");

        return $query->execute([$id]);
    }

    private function buildFieldQuery(array $params)
    {
        //craete array with fields to update in request sql, array_map on params to dertiminate field
        return join(', ', array_map(function ($field) {
            return "$field = :$field";
        }, array_keys($params)));
    }

    public function getTable(): string
    {
        return $this->table;
    }

    public function getPdo(): PDO
    {
        return $this->pdo;
    }
}
