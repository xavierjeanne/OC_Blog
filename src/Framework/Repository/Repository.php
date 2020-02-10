<?php
namespace Framework\Repository;

use PDO;
use Pagerfanta\Pagerfanta;

/**
 * repository class, action using table in database
 */
class Repository
{
    /**
     * @var \PDO
     */
    protected $pdo;

    /** */
     * @var Repository
     */
    protected $repository;

    /**
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
     */
    public function find(int $id)
    {
        $query = $this->pdo->prepare("SELECT * FROM  $this->repository WHERE id=?");
        $query->execute([$id]);
        $query->setFetchMode(\PDO::FETCH_CLASS, $this->entity);
        return $query->fetch() ?: null;
    }

     /**
     * paginate element
     *
     * @return Pagerfanta
     */
    public function findPaginated(int $perPage, int $currentPage): Pagerfanta
    {
        //get all posts and make pagination and pass entity use(can now use datetime)
        $query = new PaginatedQuery(
            $this->pdo,
            $this->paginationQuery(),
            $this->countQuery(),
            $this->entity
        );
        //return instance of pagerfanta withresult of query
        return (new Pagerfanta($query))->setMaxPerPage($perPage)->setCurrentPage($currentPage);
    }

    protected function paginationQuery():string
    {
        return 'SELECT * FROM ' . $this->repository;
    }

    protected function countQuery():string
    {
        return 'SELECT COUNT(id) FROM ' . $this->repository;
    }

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

    public function insert(array $params): bool
    {
        //craete array with fields to update in request sql, array_map on params to dertiminate field
        $fieldQuery = $this->buildFieldQuery($params);
        //create request sql
        $query = $this->pdo->prepare("INSERT INTO $this->repository SET $fieldQuery");
        return $query->execute($params);
    }

    public function delete(int $id): bool
    {
        $query = $this->pdo->prepare("DELETE FROM $this->repository WHERE id=?");
        return $query->execute([$id]);
    }

    /**
     * buildFieldQuery create the query fields with params
     *
     */
    private function buildFieldQuery(array $params)
    {
        //craete array with fields to update in request sql, array_map on params to dertiminate field
        return join(', ', array_map(function ($field) {
            return "$field = :$field";
        }, array_keys($params)));
    }

    public function getRepository(): string
    {
        return $this->repository;
    }

    public function getPdo(): PDO
    {
        return $this->pdo;
    }
}
