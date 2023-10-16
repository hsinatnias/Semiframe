<?php
declare(strict_types=1);

namespace Semiframe\DataMapper;

interface  DataMapperInterface
{
    /**
     * Prepare query statement
     * @param string $sqlQuery
     * @return self
     */
    public function prepare(string $sqlQuery): self;

    /**
     * @param $value
     * @return mixed
     */
    public function bind($value);

    /**
     * @param array $fields
     * @param bool $isSearch
     * @return mixed
     */
    public function bindParameters(array $fields, bool $isSearch = false): self;

    /**
     * @return int
     */
    public function numRows(): int;

    /**
     * @return void
     */
    public function execute();

    /**
     * @return object
     */
    public function result(): object;

    /**
     * @return array
     */
    public function results(): array;

    /**
     * This function gives the last affected row ID
     * @return int
     */
    public function getLastId(): int;


}