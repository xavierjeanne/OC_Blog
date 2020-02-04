<?php

namespace Framework;

/**
 * class method use for repository
 */
class Repository
{
    /**
     *
     * @var \PDO
     */
    protected $pdo;

    /**
     * table form database
     *
     * @var Repository
     */
    protected $repository;

    /**
     * entity
     *
     * @var string|null
     */
    protected $entity;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * return all register of an element
     *
     * @return array
     */
    public function findAll(): array
    {
        $query = $this->pdo->query("SELECT * FROM  $this->repository");
        $query->setFetchMode(\PDO::FETCH_CLASS, $this->entity);
        return $query->fetchAll();
    }

    /**
     * get an element with id
     *
     * @param integer $id
     * @return array|null
     */
    public function find(int $id)
    {
        $query = $this->pdo->prepare("SELECT * FROM  $this->repository WHERE id=?");
        $query->execute([$id]);
        $query->setFetchMode(\PDO::FETCH_CLASS, $this->entity);
        return $query->fetch() ?: null;
    }

    /**
     * update fields in database
     *
     * @param  int $id
     * @param  array $fields
     *
     * @return bool
     */
    public function update(int $id, array $params): bool
    {
        //craete array with fields to update in request sql, array_map on params to dertiminate field
        $fieldQuery = $this->buildFieldQuery($params);
        //create params id (id of the post to update)
        $params['id'] = $id;
        //create request sql
        $query = $this->pdo->prepare("UPDATE $this->repository SET $fieldQuery WHERE id=:id");
        return $query->execute($params);
    }


    /**
     * insert an element in database
     *
     * @param  mixed $params
     *
     * @return bool
     */
    public function insert(array $params): bool
    {
        //craete array with fields to update in request sql, array_map on params to dertiminate field
        $fieldQuery = $this->buildFieldQuery($params);
        //create request sql
        $query = $this->pdo->prepare("INSERT INTO $this->repository SET $fieldQuery");
        return $query->execute($params);
    }


    /**
     * delete an element
     *
     * @param  int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $query = $this->pdo->prepare("DELETE FROM $this->repository WHERE id=?");
        return $query->execute([$id]);
    }

    /**
     * buildFieldQuery create the query fields with params
     *
     * @param  array $params
     *
     * @return void
     */
    private function buildFieldQuery(array $params)
    {
        //craete array with fields to update in request sql, array_map on params to dertiminate field
        return join(', ', array_map(function ($field) {
            return "$field = :$field";
        }, array_keys($params)));
    }
}
