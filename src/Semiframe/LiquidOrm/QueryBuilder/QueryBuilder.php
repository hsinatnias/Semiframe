<?php
declare(strict_types=1);

namespace Semiframe\LiquidOrm\QueryBuilder;

use Semiframe\LiquidOrm\QueryBuilder\Exception\QueryBuilderInvalidArgumentException;

class QueryBuilder implements QueryBuilderInterface
{

    protected array $key;

    protected const SQL_DEFAULT = [
        'selectors' => [],
        'replace' => false,
        'distinct' => false,
        'from' => [],
        'where' => null,
        'and' => [],
        'or' => [],
        'orderBy' => [],
        'fields' => [],
        'primary_key' => '',
        'table' => '',
        'type' => '',
        'raw' => ''
    ];

    /**
     * @return void
     */
    public function __constructor()
    {

    }

    public function buildQuery(array $args = []): self
    {
        if (count($args) < 0) {
            throw new QueryBuilderInvalidArgumentException();
        }
        $arg = array_merge(self::SQL_DEFAULT, $args);
        $this->key = $arg;
        return  $this;
    }

    public function insertQuery(): string
    {

    }

    public function selectQuery(): string
    {
        // TODO: Implement selectQuery() method.
    }

    public function updateQuery(): string
    {
        // TODO: Implement updateQuery() method.
    }

    public function deleteQuery(): string
    {
        // TODO: Implement deleteQuery() method.
    }

    public function rawQuery(): string
    {
        // TODO: Implement rawQuery() method.
    }
}