<?php

namespace Appwrite\Extend;

class PostgreSQLStatement
{
    protected $pdo;
    protected int $counter;
    protected string $statement;

    protected array $values = [];
    protected mixed $res;

    public function __construct(&$pdo, int $counter, string $statement)
    {
        $this->pdo = $pdo;
        $this->counter = $counter;
        $this->statement = $statement;
    }

    public function bindValue(string $key, mixed $value, string $type): self
    {
        $this->values[] = [
            'key' => $key,
            'value' => $value,
            'type' => $type
        ];

        return $this;
    }

    public function execute()
    {
        foreach ($this->values as $i => $value) {
            $this->statement = str_replace($value['key'], '$' . ($i + 1), $this->statement);
        }
        $this->pdo->prepare($this->counter, $this->statement);
        $this->res = $this->pdo->execute($this->counter, array_map(fn ($v) => $v['value'], $this->values));

        return $this->res;
    }

    public function fetchAll($type)
    {
        return $this->pdo->fetchAll($this->res);
    }

    public function fetch($type)
    {
        return $this->pdo->fetchAssoc($this->res, 0);
    }
}
