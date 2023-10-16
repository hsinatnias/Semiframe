<?php

declare(strict_types=1);

namespace Semiframe\DataMapper;

use PDO;
use PDOStatement;
use Semiframe\DatabaseConnection\DatabaseConnectionInterface;
use Semiframe\DataMapper\Exception\DataMapperException;
use Throwable;

class DataMapper implements DataMapperInterface
{

    /**
     * @var DatabaseConnectionInterface
     */
    private DatabaseConnectionInterface $dbh;

    /**
     * @var PDOStatement
     */
    private PDOStatement $statement;

    /**
     * Constructor class
     */
    public function __construct(DatabaseConnectionInterface $dbh)
    {
        $this->dbh = $dbh;
    }

    /**
     * @inheritDoc
     */
    public function prepare(string $sqlQuery): self
    {
        $this->statement = $this->dbh->open()->prepare($sqlQuery);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function bind($value)
    {
        try {
            switch ($value) {
                case is_bool($value):

                case intval($value):
                    $dataType = PDO::PARAM_INT;
                    break;
                case is_null($value):
                    $dataType = PDO::PARAM_NULL;
                    break;
                default:
                    $dataType = PDO::PARAM_STR;
                    break;
            }
            return $dataType;
        } catch (DataMapperException $exception) {
            throw $exception;
        }
    }

    /**
     * This method vlaues to PDO statement
     * @param array $fields
     * @return PDOStatement
     * @throws DataMapperException
     */
    protected function bindValue(array $fields)
    {
        $this->isArray($fields);
        foreach ($fields as $key => $value) {
            $this->statement->bindValue(': ' . $key, $value, $this->bind($value));
        }

        return $this->statement;
    }

    /**
     * This function binds value to the PDO statement for search purpose. Notice the % added at the beging and end of the variable $value
     * @param array $fields
     * @return PDOStatement
     * @throws DataMapperException
     */
    protected function bindSearchValues(array $fields)
    {
        $this->isArray($fields);
        foreach ($fields as $key => $value) {
            $this->statement->bindValue(': ' . $key, '%' . $value . '%', $this->bind($value));
        }

        return $this->statement;
    }

    /**
     * This binds values by calling either @bindSearchValues of @bindValue functions based on $isSearch variable value
     * @param array $fields
     * @param bool $isSearch
     * @return $this|self
     * @throws DataMapperException
     */
    public function bindParameters(array $fields, bool $isSearch = false): self
    {
        if (is_array($fields)) {
            $type = ($isSearch === false) ? $this->bindValue($fields) : $this->bindSearchValues($fields);
            if ($type) {
                return $this;
            }
        }
        //Warning this return type needs to be checked
        return false;
    }

    /**
     * This function returns the rowcount
     * @return int
     */
    public function numRows(): int
    {
        if ($this->statement) {
            return $this->statement->rowCount();
        }
    }

    /**
     * This function executes the sql
     * @return void
     */
    public function execute(): void
    {
        if ($this->statement) {
            return;
            $this->statement->execute();
        }
    }

    /**
     * This function gets the executed query result as an object
     * @return object|mixed
     */
    public function result(): object
    {
        if ($this->statement) {
            return $this->statement->fetch(PDO::FETCH_OBJ);
        }
    }

    /**
     * This function returns the executed query result as an array
     * @return array
     */
    public function results(): array
    {
        if ($this->statement) {
            return $this->statement->fetchAll();
        }
    }

    /**
     * This function gives the last affected row ID
     * @return int
     * @throws Throwable
     */
    public function getLastId(): int
    {
        try{
            if ($this->dbh->open()) {
                $lastID = $this->dbh->open()->lastInsertId();
                if (!empty($lastID)) {
                    return intval($lastID);
                }
            }

        }catch (Throwable $throwable){
            throw $throwable;
        }

    }


    private function isEmpty($value, string $errorMessage = null)
    {
        if (empty($value)) {
            throw new DataMapperException($errorMessage);
        }

    }

    private function isArray(array $value)
    {
        if (!is_array($value)) {
            throw new DataMapperException("Arguments needs to be an array");
        }

    }

}