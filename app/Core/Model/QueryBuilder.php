<?php


namespace App\Core\Model;


use App\Core\Application;
use PDO;

class QueryBuilder
{
    private array $select = ['*'];
    private array $wheres = [];
    protected \PDO $connection;
    protected int $limit = 1000;

    public function __construct(private string $table, private string $class)
    {
        $this->connection = Application::instance()->db();

    }

    public function select(...$params): self
    {
        $this->select = $params;
        return $this;
    }

    public function where(string $column, mixed $operator, mixed $value = null, string $binding = 'and'): self
    {
        if ($value === null) {
            $value = is_callable($operator) ? $operator() : $operator;
            $operator = '=';
        }
        $this->wheres[$binding][] = compact('column', 'operator', 'value');
        return $this;
    }


    public function get()
    {
        return $this->resolveQuery()->fetchAll(PDO::FETCH_CLASS, $this->class);
    }

    private function resolveQuery(): ?\PDOStatement
    {
        $select = implode(',', $this->select);
        $where = $this->getWhere();
        $query = "select $select from $this->table where $where limit $this->limit";
        return $this->connection
            ->query($query);
    }

    public function whereIn(string $column, array $value): self
    {
        $this->where($column, ' in ', $value);
        return $this;
    }

    public function whereNotIn(string $column, array $value): self
    {
        $this->where($column, ' not in ', $value);
        return $this;
    }

    public function andWhere(string $column, mixed $operator, mixed $value = null): self
    {
        $this->where($column, $operator, $value);
        return $this;
    }

    public function orWhere(string $column, mixed $operator, mixed $value = null): self
    {
        $this->where($column, $operator, $value, 'or');
        return $this;
    }


    private function getWhere(): string
    {
        $ands = $this->wheres['and'];
        $ors = $this->wheres['or'] ?? [];

        $where = '';
        foreach ($ands as $value) {
            $where .= ' ' . $value['column'] . ' ' . $value['operator'] . ' ' . $this->getValue($value['value']);
            if (end($ands) !== $value)
                $where .= ' and ';
        }
        if (count($ors)) {
            $where .= ' or ( ';
        }
        foreach ($ors as $value) {
            $where .= ' ' . $value['column'] . ' ' . $value['operator'] . ' ' . $this->getValue($value['value']);
            if (end($ors) !== $value)
                $where .= ' and';
            else
                $where .= ' )';
        }

        return $where;
    }

    private function getValue(mixed $value): mixed
    {
        return match (getType($value)) {
            "boolean" => (bool)($value),
            "integer" => (int)($value),
            "double" => (float)($value),
            "string" => "'" . $value . "'",
            "array" => "( " . join(',', $value) . " )",
            "object" => $value,
            "NULL" => null,
            "resource", "unknown type", "resource (closed)" => throw new \ValueError('type error')
        };
    }

}